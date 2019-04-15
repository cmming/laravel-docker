<?php

namespace App\Http\Controllers\User;

use App\Models\BookingTermicalOrders;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;


use App\User;
use App\Transformers\UserTransformer;
use App\Transformers\BookingTermicalOrdersTransformer;

class IndexController extends Controller
{
    private $user;
    private $bookingTermicalOrders;
    //
    public function __construct(User $user,BookingTermicalOrders $bookingTermicalOrders)
    {
        $this->user = $user;
        $this->bookingTermicalOrders = $bookingTermicalOrders;
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
            'name' => 'required|string'
        ]);
        if ($validator->fails()) {
            return $this->errorBadRequest($validator);
        }

        $newUser = [
            'name' => $request->input('name'),
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

    /**
     * 用户的预约订单
     */
    public function termicalOrders(){
        //预加载多个关联 减少数据查询的次数
//        dd( auth()->user()->id);
        $userBookingTermicalOrders = $this->bookingTermicalOrders->where('user_id','=',auth()->user()->id)->with(['user','termical'])->paginate();
//        dd($userBookingTermicalOrders);
        return $this->response->paginator($userBookingTermicalOrders, new BookingTermicalOrdersTransformer());

    }

}
