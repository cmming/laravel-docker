<?php

namespace App\Http\Controllers\Role;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Role;
use App\Transformers\RoleTransformer;

class IndexController extends Controller
{
    //

    private $role;

    public function __construct(Role $role)
    {
        $this->role = $role;
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
        $validator = \Validator::make(request()->all()+ ['id' => $id], [
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
        $validator = \Validator::make(['id'=>$id], [
            'id' => 'required|exists:roles,id',
        ]);
        if ($validator->fails()) {
            return $this->errorBadRequest($validator);
        }

        $this->role->find($id)->delete();
    }


}
