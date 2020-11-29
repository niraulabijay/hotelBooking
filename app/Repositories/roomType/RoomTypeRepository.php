<?php

namespace App\Repositories\roomType;

use App\Model\Booking;
use App\Model\RoomType;

class RoomTypeRepository implements RoomTypeInterface {

    public function getByIds($ids = []){
        $roomTypes = RoomType::whereIn('id',$ids)->get($this->formatMultiple());
        return $roomTypes;
    }

    protected function formatMultiple(){
        return [
            'id', 'title', 'slug', 'status', 'description', 'no_of_adult',
            'base_price', 'hotel_id'
        ];
    }

}
