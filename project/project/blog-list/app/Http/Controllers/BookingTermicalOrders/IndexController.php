<?php

namespace App\Http\Controllers\BookingTermicalOrders;

use App\Models\BookingTermicalOrders;
use App\Transformers\BookingTermicalOrdersTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    //
    private $bookingTermicalOrders;

    public function __construct(BookingTermicalOrders $bookingTermicalOrders)
    {
        $this->bookingTermicalOrders = $bookingTermicalOrders;
    }

    public function index()
    {
        $bookingTermicalOrders = $this->bookingTermicalOrders->paginate();

        return $this->response->paginator($bookingTermicalOrders, new BookingTermicalOrdersTransformer());
    }

    public function getOnlineTermicalOrders(){

        $bookingTermicalOrders = $this->bookingTermicalOrders->where('state','=',2)->paginate();

        return $this->response->paginator($bookingTermicalOrders, new BookingTermicalOrdersTransformer());
    }

    public function store(Request $request)
    {
        $validator = \Validator::make(request()->all(), [
            'termical_id' => 'required|exists:booking_termicals,id',
            'date' => 'required|date_format:"Y-m-d"',
            'start_time' => 'required|date_format:"H:i"',
            'end_time' => 'required|date_format:"H:i"',
        ]);

        if ($validator->fails()) {
            return $this->errorBadRequest($validator);
        }

        $bookingTermicalOrder = [
            'termical_id' => $request->input('termical_id'),
            'date' => $request->input('date'),
            'start_time' => $request->input('start_time'),
            'end_time' => $request->input('end_time'),
            'btime' => $request->input('date').' '.$request->input('start_time'),
            'etime' =>  $request->input('date').' '.$request->input('end_time'),
        ];

        $bookingTermicalOrder = $this->bookingTermicalOrders->create($bookingTermicalOrder);

        if ($bookingTermicalOrder) {
            return $this->response->created();
        } else {
            return $this->createError();
        }
    }

    public function update($id, Request $request)
    {
        $validator = \Validator::make(request()->all() + ['id' => $id], [
            'id' => 'required|exists:booking_termical_orders,id',
            'termical_id' => 'required|exists:booking_termicals,id',
            'date' => 'required|date_format:"Y-m-d"',
            'start_time' => 'required|date_format:"H:i"',
            'end_time' => 'required|date_format:"H:i"',
            'state' => 'required|in:1,2,3,4,5',

        ]);
        if ($validator->fails()) {
            return $this->errorBadRequest($validator);
        }

        $bookingTermicalOrder = [
            'termical_id' => $request->input('termical_id'),
            'date' => $request->input('date'),
            'start_time' => $request->input('start_time'),
            'end_time' => $request->input('end_time'),
            'btime' => $request->input('date').' '.$request->input('start_time'),
            'etime' =>  $request->input('date').' '.$request->input('end_time'),
            'state' => $request->input('state'),
        ];
        $result = $this->bookingTermicalOrders->find($id)->update($bookingTermicalOrder);
        if ($result) {
            return $this->response->noContent();
        } else {
            return $this->updateError();
        }
    }

    public function delete($id)
    {
        $validator = \Validator::make(['id' => $id], [
            'id' => 'required|exists:booking_termical_orders,id',
        ]);
        if ($validator->fails()) {
            return $this->errorBadRequest($validator);
        }

        $result = $this->bookingTermicalOrders->find($id)->delete();

        if ($result) {
            return $this->response->noContent();
        } else {
            return $this->deleteError();
        }
    }

    public function show($id){
        $validator = \Validator::make(['id' => $id], [
            'id' => 'required|exists:booking_termical_orders,id',
        ]);

        if ($validator->fails()) {
            return $this->errorBadRequest($validator);
        }
        $bookingTermicalOrder = $this->bookingTermicalOrders->find($id);
        return $this->response->item($bookingTermicalOrder, new BookingTermicalOrdersTransformer());
    }
}
