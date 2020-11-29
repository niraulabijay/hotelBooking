<?php
/**
 * Created by PhpStorm.
 * User: Bijay
 * Date: 11/5/2020
 * Time: 10:11 PM
 */

namespace App\Repositories\hotel;


interface HotelInterface
{
    public function findById($id);

    public function getAuthHotel();

    public function activeRoomTypes($hotel);

}