<?php

namespace App\Http\Controllers\User;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;


use App\User;
use App\Transformers\UserTransformer;

class IndexController extends Controller
{
    private $user;
    private $bookingTermicalOrders;

    //
    public function __construct(User $user, Role $role)
    {
        $this->user = $user;
        $this->role = $role;
    }

    public function index()
    {
        $users = $this->user->paginate();

        return $this->response->paginator($users, new UserTransformer());
    }

    public function show($id)
    {
        $validator = \Validator::make(['id' => $id], [
            'id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return $this->errorBadRequest($validator);
        }
        $user = $this->user->find($id);
        return $this->response->item($user, new UserTransformer());
    }

    public function store(Request $request)
    {
        $validator = \Validator::make(request()->all(), [
            'email' => 'email|unique:users,email',
            'name' => 'required|string||unique:users,name',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->errorBadRequest($validator);
        }

        $newUser = [
            'email' => $request->input('email'),
            'name' => $request->input('name'),
            'password' => bcrypt($request->input('password'))
        ];

        \DB::beginTransaction();
        try{
            $user = $this->user->create($newUser);
            $this->updateUserRoles($request['roles'], $user);
            \DB::commit();
            return $this->response->created();
        }catch (\Exception $e) {
            \DB::rollBack();
            \Log::error('用户创建失败');
            return $this->createError();
        }
    }

    public function ResetPwd(Request $request)
    {
        $validator = \Validator::make(request()->all(), [
            'password' => 'required',
            'newPassword' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->errorBadRequest($validator);
        }

        $user = auth()->user()->toArray();

        $credentials = ['email' => $user['email'], 'password' => $request->get('password')];

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['errors' => [["field" => "password", 'code' => '密码错误']]], 422);
        }

        auth()->user()->update(['newPassword' => bcrypt($request->input('newPassword'))]);

        return $this->response->noContent();


    }

    public function update($id, Request $request)
    {
        $validator = \Validator::make(request()->all() + ['id' => $id], [
            'id' => 'required|exists:users,id',
            'name' => 'required|string'
        ]);
        if ($validator->fails()) {
            return $this->errorBadRequest($validator);
        }

        $newUser = [
            'name' => $request->input('name'),
        ];
        $this->user->find($id)->update($newUser);

        \DB::beginTransaction();
        try{
            $curentUser = $this->user->find($id);
            $user = $curentUser->update($newUser);
            $this->updateUserRoles($request['roles'], $curentUser);
            \DB::commit();
            return $this->response->noContent();
        }catch (\Exception $e) {
            \DB::rollBack();
            return $this->updateError();
        }



        return $this->response->noContent();
    }

    public function delete($id)
    {
        $validator = \Validator::make(['id' => $id], [
            'id' => 'required|exists:users,id',
        ]);
        if ($validator->fails()) {
            return $this->errorBadRequest($validator);
        }

        $this->user->find($id)->delete();

        return $this->response->noContent();
    }

    public function setInstructions(Request $request)
    {
        $instructions = $request->get('instructions');
        \Log::info($instructions);
        return Redis::set('name', $instructions);
    }

    public function getInstructions()
    {
        return Redis::get('name');
    }


    public function captcha()
    {
//        return \Captcha::img('1111111111');
        return $this->response->array(app('captcha')->create('default', true));
    }

    public function updateUserRoles($roles, $user)
    {
        //数组验证
        $validator = \Validator::make(['roles' => $roles], [
            'roles' => 'array',
        ]);
        if ($validator->fails()) {
            return $this->errorBadRequest($validator);
        }
        //验证数组的每一项
        //TODO 错误没有成功抛出
        foreach ($roles as $role) {
            $validator = \Validator::make(['role' => $role], [
                'role' => 'exists:roles,id',
            ]);
            if ($validator->fails()) {
                return $this->errorBadRequest($validator);
            }
        }

        //选中的角色
        $checkRoles = $this->role->findMany($roles);
        //用户拥有的角色
        $userRoles = $user->roles;

        //添加的角色
        $addRoles = $checkRoles->diff($userRoles);
        foreach ($addRoles as $addRole) {
            $user->addRoles($addRole);
        }

        //删除的角色
        //减少的
        $delRoles = $userRoles->diff($checkRoles);
        foreach ($delRoles as $delRole) {
            $user->deleteRoles($delRole);
        }


    }


}
