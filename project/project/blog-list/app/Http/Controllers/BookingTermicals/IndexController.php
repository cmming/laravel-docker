<?php

namespace App\Http\Controllers\BookingTermicals;

use App\Models\BookingTermicals;
use App\Models\BookingTermicalOrders;
use App\Transformers\BookingTermicalsTransformer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{

    private $bookingTermical;
    private $bookingTermicalOrders;

    public function __construct(BookingTermicals $bookingTermicals, BookingTermicalOrders $bookingTermicalOrders)
    {
        $this->bookingTermical = $bookingTermicals;
        $this->bookingTermicalOrders = $bookingTermicalOrders;
    }

    //
    public function index(Request $request)
    {
        //1.搜索不可用的机器
        //获取参数的结束时间 大于表中的开始时间
        $validator = \Validator::make(request()->all(), [
            'date' => 'date_format:"Y-m-d"',
            'start_time' => 'date_format:"H:i"',
            'end_time' => 'date_format:"H:i"',
        ]);
        if ($validator->fails()) {
            return $this->errorBadRequest($validator);
        }
        //凭借开始时间和结束时间
        $btime = $request->input('date') . ' ' . $request->input('start_time');
        $etime = $request->input('date') . ' ' . $request->input('end_time');
        $btime = Carbon::parse($btime)->addSecond()->toDateTimeString();
        $etime = Carbon::parse($etime)->subSecond()->toDateTimeString();
//        dd($btime,$etime);
        // 添加时间搜索条件  开始时间加一秒 结束时间减一秒
        $result = $this->bookingTermicalOrders->WhereBetween('btime',[$btime,$etime])->orWhereBetween('etime',[$btime,$etime])->get(['termical_id']);

        $result = array_column($result->toArray(),'termical_id');

        $data = $this->bookingTermical->whereNotIn('id',$result)->paginate();
//        dd($result);
//        return $this->response->array($result->toArray());
//        $bookingTermicals = $this->bookingTermical->paginate();


        return $this->response->paginator($data, new BookingTermicalsTransformer());
    }


    public function store(Request $request)
    {
        $validator = \Validator::make(request()->all(), [
            'name' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->errorBadRequest($validator);
        }

        $bookingTermicals = [
            'name' => $request->input('name'),
        ];

        $bookingTermicals = $this->bookingTermical->create($bookingTermicals);

        if ($bookingTermicals) {
            return $this->response->created();
        } else {
            return $this->createError();
        }

    }

    public function update($id, Request $request)
    {
        $validator = \Validator::make(request()->all() + ['id' => $id], [
            'id' => 'required|exists:booking_termicals,id',
            'name' => 'required|string',
            'state' => 'required|in:1,2',
        ]);
        if ($validator->fails()) {
            return $this->errorBadRequest($validator);
        }

        $newBookingTermical = [
            'name' => $request->input('name'),
            'state' => $request->input('state'),
        ];
        $result = $this->bookingTermical->find($id)->update($newBookingTermical);
        if ($result) {
            return $this->response->noContent();
        } else {
            return $this->updateError();
        }

    }

    public function delete($id)
    {
        $validator = \Validator::make(['id' => $id], [
            'id' => 'required|exists:booking_termicals,id',
        ]);
        if ($validator->fails()) {
            return $this->errorBadRequest($validator);
        }

        $result = $this->bookingTermical->find($id)->delete();

        if ($result) {
            return $this->response->noContent();
        } else {
            return $this->deleteError();
        }
    }

    public function show($id){
        $validator = \Validator::make(['id' => $id], [
            'id' => 'required|exists:booking_termicals,id',
        ]);

        if ($validator->fails()) {
            return $this->errorBadRequest($validator);
        }
        $bookingTermical = $this->bookingTermical->find($id);
        return $this->response->item($bookingTermical, new BookingTermicalsTransformer());
    }
}
