<?php
/**
 * Created by PhpStorm.
 * User: Bijay
 * Date: 11/29/2020
 * Time: 11:58 AM
 */

namespace App\Repositories\hotelSetting;


interface HotelSettingInterface
{
    public function storeDirectMetas($request, $keys, $hotel);
}