<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Models\BookingTermicals;

class BookingTermicalOrders extends Model
{
    //
    protected $table = "booking_termical_orders";
    protected $guarded = [];

    public function user()
    {
        return $this->hasOne(User::class,'id','user_id');
    }

    public function termical()
    {
        return $this->hasOne( BookingTermicals::class,'id','termical_id');
    }
}
