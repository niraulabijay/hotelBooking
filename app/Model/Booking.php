<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use SoftDeletes;
    //Booking Statuses
    const STATUS_ACTIVE = 1;
    const STATUS_CHECKIN = 2;
    const STATUS_CHECKOUT  = 3;
    const STATUS_CANCELLED = 4;
    const STATUS_ABADONED = 5;

    protected $fillable = [
        'user_id', 'room_id', 'check_in', 'check_out', 'booking_room_price', 'status',
        'first_name', 'last_name', 'address', 'postCode', 'city', 'country', 'phone', 'message'
    ];

    public function rooms(){
        return $this->belongsToMany(Room::class,'booking_details','booking_id','room_id');
    }


    public static function listStatus()
    {
        return [
            self::STATUS_ACTIVE    => 'Active',
            self::STATUS_CHECKIN => 'Suspended',
            self::STATUS_CHECKOUT  => 'Inactive',
            self::STATUS_CANCELLED  => 'Inactive',
            self::STATUS_ABADONED  => 'Inactive'
        ];
    }

    public function statusLabel()
    {
        $list = self::listStatus();
        // little validation here just in case someone mess things
        // up and there's a ghost status saved in DB
        return isset($list[$this->status])
            ? $list[$this->status]
            : $this->status;
    }

    public function bookingDetails(){
        return $this->hasMany(BookingDetail::class,'booking_id');
    }

    public function user(){
        return $this->belongsTo(User::Class,'user_id');
    }

    public function full_name(){
        return $this->first_name.' '.$this->last_name;
    }

}
