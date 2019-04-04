<?php

namespace App\Http\Controllers\BookingTimes;

use App\Models\BookingTimes;
use App\Transformers\BookingTimesTransformer;
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
}
