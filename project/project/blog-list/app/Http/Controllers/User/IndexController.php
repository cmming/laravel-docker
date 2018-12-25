<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;


use App\User;
use App\Transformers\UserTransformer;

class IndexController extends Controller
{
    private $user;
    //
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index()
    {
        $users = $this->user->paginate(1);

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
            'name' => 'required|string',
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

        $user = $this->user->create($newUser);

        return $this->response->created();
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
        $validator = \Validator::make(request()->all()+ ['id' => $id], [
            'id' => 'required|exists:users,id',
            'name' => 'required|string',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->errorBadRequest($validator);
        }

        $newUser = [
            'name' => $request->input('name'),
            'password' => bcrypt($request->input('password'))
        ];
        $this->user->find($id)->update($newUser);

        return $this->response->noContent();
    }

    public function delete($id)
    {
        $validator = \Validator::make(['id'=>$id], [
            'id' => 'required|exists:users,id',
        ]);
        if ($validator->fails()) {
            return $this->errorBadRequest($validator);
        }

        $this->user->find($id)->delete();
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

}
