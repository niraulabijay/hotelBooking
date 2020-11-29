<?php

namespace App\Repositories\hotel;

use App\Model\Hotel;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class HotelRepository implements HotelInterface {

    public function findById($id){
        return Hotel::find($id);
    }

    public function getAuthHotel(){
        if(Sentinel::getUser()->roles->first()->slug=="admin" || Sentinel::getUser()->roles->first()->slug=="developer"){
            $hotel_id = Hotel::first()->id;
        }else{
            $hotel_id = Sentinel::getUser()->hotel_id;
        }
        return $this->findById($hotel_id);
    }

    public function activeRoomTypes($hotel)
    {
        return $hotel->roomTypes->where('status','Active');
    }
}
