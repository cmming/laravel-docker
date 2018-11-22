<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;


use App\User;
use App\Transformers\UserTransformer;

class IndexController extends Controller
{
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

    public function show()
    {
    }

    public function store()
    {
    }

    public function ResetPwd()
    {
    }

    public function update()
    {
    }

    public function delete()
    {
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

}
