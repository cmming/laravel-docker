<?php

namespace App\Http\Controllers\BookingTermicals;

use App\Models\BookingTermicals;
use App\Models\BookingTermicalOrders;
use App\Transformers\BookingTermicalsTransformer;
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
            'date' => 'required|date_format:"Y-m-d"',
            'start_time' => 'required|date_format:"H:i:s"',
            'end_time' => 'required|date_format:"H:i:s"',
        ]);
        if ($validator->fails()) {
            return $this->errorBadRequest($validator);
        }
        //凭借开始时间和结束时间
        $btime = $request->input('date') . ' ' . $request->input('start_time');
        $etime = $request->input('date') . ' ' . $request->input('end_time');
//        dd($btime,$etime);
        // 添加时间搜索条件
        $result = $this->bookingTermicalOrders->orWhereBetween('start_time',[$btime,$etime])->orWhereBetween('end_time',[$btime,$etime])->get();
//        dd($result);
        return $this->response->array($result->toArray());
        $bookingTermicals = $this->bookingTermical->paginate();


        return $this->response->paginator($bookingTermicals, new BookingTermicalsTransformer());
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
}
