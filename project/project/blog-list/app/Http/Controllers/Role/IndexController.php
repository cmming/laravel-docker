<?php

namespace App\Http\Controllers\Role;

use App\Models\Router;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Role;
use App\Transformers\RoleTransformer;

class IndexController extends Controller
{
    //

    private $role;
    private $router;

    public function __construct(Role $role, Router $router)
    {
        $this->role = $role;
        $this->router = $router;
    }


    public function index()
    {
        $users = $this->role->paginate();

        return $this->response->paginator($users, new RoleTransformer());
    }


    public function show($id)
    {
        $validator = \Validator::make(['id' => $id], [
            'id' => 'required|exists:roles,id',
        ]);

        if ($validator->fails()) {
            return $this->errorBadRequest($validator);
        }
        $user = $this->role->find($id);
        return $this->response->item($user, new RoleTransformer());
    }

    public function store(Request $request)
    {
        $validator = \Validator::make(request()->all(), [
            'name' => 'required|string',
            'description' => 'required|string',
        ]);
        if ($validator->fails()) {
            return $this->errorBadRequest($validator);
        }

        $newRoles = [
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ];

        $role = $this->role->create($newRoles);

        return $this->response->created();
    }


    public function update($id, Request $request)
    {
        $validator = \Validator::make(request()->all() + ['id' => $id], [
            'id' => 'required|exists:roles,id',
            'name' => 'required|string',
            'description' => 'required|string',
        ]);
        if ($validator->fails()) {
            return $this->errorBadRequest($validator);
        }

        $newRoles = [
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ];
        $this->role->find($id)->update($newRoles);

        return $this->response->noContent();
    }


    public function delete($id)
    {
        $validator = \Validator::make(['id' => $id], [
            'id' => 'required|exists:roles,id',
        ]);
        if ($validator->fails()) {
            return $this->errorBadRequest($validator);
        }

        $this->role->find($id)->delete();
    }

    public function routers($id)
    {
        $validator = \Validator::make(['id' => $id], [
            'id' => 'required|exists:roles,id',
        ]);
        if ($validator->fails()) {
            return $this->errorBadRequest($validator);
        }

        $routers = $this->role->find($id)->routers()->get()->toArray();

        $role_routers = array_column($routers, 'id');
        return $this->response->array($role_routers);
    }


    public function storeRouter($id)
    {
        //TODO 没有检测路由的id
        $validator = \Validator::make(request(['routers_id']), [
            'routers_id' => 'required|array',
        ]);
        if ($validator->fails()) {
            return $this->errorBadRequest($validator);
        }
        //获取这个橘色之前拥有的菜单
        $role = $this->role->find($id);
        $roleRouter = $role->routers;

        //选中的
        $checkRoleRouter = $this->router->findMany(request('routers_id'));

        //添加的
        $addRouters = $checkRoleRouter->diff($roleRouter);
        foreach ($addRouters as $addRouter) {
            $role->addRouter($addRouter);
        }

        //减少的
        $delRouters = $roleRouter->diff($checkRoleRouter);
        foreach ($delRouters as $delRouter) {
            $role->detachRouter($delRouter);
        }


        return $this->response->noContent();
    }


}
