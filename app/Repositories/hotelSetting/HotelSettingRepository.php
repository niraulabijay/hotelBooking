<?php
/**
 * Created by PhpStorm.
 * User: Bijay
 * Date: 11/29/2020
 * Time: 11:58 AM
 */

namespace App\Repositories\hotelSetting;


use App\Model\HotelSetting;

class HotelSettingRepository implements HotelSettingInterface
{
    public function storeDirectMetas($request, $keys, $hotel)
    {
        foreach ($keys as $key){
            if($request[$key]){
                $matches = [
                    'hotel_id' => $hotel->id,
                    'key' => $key,
                ];
                HotelSetting::updateOrCreate($matches,[
                    'value' => $request[$key]
                ]);
            }
        }
    }
}