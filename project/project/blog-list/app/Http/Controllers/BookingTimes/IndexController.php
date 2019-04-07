<?php

namespace App\Http\Controllers\BookingTimes;

use App\Models\BookingTimes;
use App\Transformers\BookingTimesTransformer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    //
    private $bookingTimes;

    public function __construct(BookingTimes $bookingTimes)
    {
        $this->bookingTimes = $bookingTimes;
    }

    public function index()
    {
        $bookingTimes = $this->bookingTimes->paginate();

        return $this->response->paginator($bookingTimes, new BookingTimesTransformer());
    }

    public function store(Request $request)
    {
        $validator = \Validator::make(request()->all(), [
            'start_time' => 'required|date_format:"H:i:s"',
            'end_time' => 'required|date_format:"H:i:s"',
            'time' => 'required|date_format:"H:i:s"',
            'date_length' => 'required|integer',
            'start_date' => 'required|date_format:"Y-m-d H:i:s"',
            'end_date' => 'required|date_format:"Y-m-d H:i:s"',
        ]);

        if ($validator->fails()) {
            return $this->errorBadRequest($validator);
        }

        $newBookingTime = [
            'start_time' => $request->input('start_time'),
            'end_time' => $request->input('end_time'),
            'time' => $request->input('time'),
            'date_length' => $request->input('date_length'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
        ];

        $request = $this->bookingTimes->create($newBookingTime);

        if ($request) {
            return $this->response->created();
        } else {
            return $this->createError();
        }
    }

    public function update($id, Request $request)
    {
        $validator = \Validator::make(request()->all() + ['id' => $id], [
            'id' => 'required|exists:booking_times,id',
            'start_time' => 'required|date_format:"H:i"',
            'end_time' => 'required|date_format:"H:i"',
            'time' => 'required|date_format:"H:i"',
            'date_length' => 'required|integer',
            'start_date' => 'required|date_format:"Y-m-d"',
            'end_date' => 'required|date_format:"Y-m-d"',
        ]);
        if ($validator->fails()) {
            return $this->errorBadRequest($validator);
        }

        $newBookingTime = [
            'start_time' => $request->input('start_time'),
            'end_time' => $request->input('end_time'),
            'time' => $request->input('time'),
            'date_length' => $request->input('date_length'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
        ];
        $result = $this->bookingTimes->find($id)->update($newBookingTime);
        if ($result) {
            return $this->response->noContent();
        } else {
            return $this->updateError();
        }
    }

    public function delete($id)
    {
        $validator = \Validator::make(['id' => $id], [
            'id' => 'required|exists:booking_times,id',
        ]);
        if ($validator->fails()) {
            return $this->errorBadRequest($validator);
        }

        $result = $this->bookingTimes->find($id)->delete();

        if ($result) {
            return $this->response->noContent();
        } else {
            return $this->deleteError();
        }
    }

    public function show($id){
        $validator = \Validator::make(['id' => $id], [
            'id' => 'required|exists:booking_times,id',
        ]);

        if ($validator->fails()) {
            return $this->errorBadRequest($validator);
        }
        $bookingTime = $this->bookingTimes->find($id);

        return $this->response->item($bookingTime, new BookingTimesTransformer());
    }

    public function getCurentTimeConfig(){

        $dt = Carbon::now();

        $bookingTime = $this->bookingTimes->where('start_date','<',$dt)->where('end_date','>',$dt)->first()->toArray();

//        dd($bookingTime);
        $result = [
            'start_time'=>Carbon::parse($bookingTime['start_time'])->format('H:i'),
            'end_time'=>Carbon::parse($bookingTime['end_time'])->format('H:i'),
            'time'=>Carbon::parse($bookingTime['time'])->format('H:i'),
            'date_length'=>$bookingTime['date_length'],
            'times'=>strtotime($dt->toDateTimeString())
        ];

        return $this->response->array($result);
//        return $this->response->item($result, new BookingTimesTransformer());
    }
}
