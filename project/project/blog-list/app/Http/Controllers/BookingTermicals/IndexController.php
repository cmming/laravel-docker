<?php

namespace App\Http\Controllers\BookingTermicals;

use App\Models\BookingTermicals;
use App\Transformers\BookingTermicalsTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{

    private $bookingTermical;

    public function __construct(BookingTermicals $bookingTermicals)
    {
        $this->bookingTermical = $bookingTermicals;
    }

    //
    public function index(){
        $bookingTermicals = $this->bookingTermical->paginate();

        return $this->response->paginator($bookingTermicals,new BookingTermicalsTransformer());
    }


    public function store(Request $request){
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

        if ($bookingTermicals){
            return $this->response->created();
        }else{
            return $this->response->error(__("Create error"), 404);
        }

    }
}
