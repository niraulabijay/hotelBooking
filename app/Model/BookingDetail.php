<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class BookingDetail extends Model
{
    protected $fillable = [
        'booking_id', 'room_id', 'guests', 'allocated_price', 'instructions'
    ];
}
