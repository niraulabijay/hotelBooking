<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Repositories\hotel\HotelInterface;
use App\Repositories\hotelSetting\HotelSettingInterface;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class HotelSettingController extends Controller
{
    protected $hotel, $hotelSetting;
    public function __construct(HotelInterface $hotel, HotelSettingInterface $hotelSetting)
    {
        $this->hotel = $hotel;
        $this->hotelSetting = $hotelSetting;
    }

    public function index($id){
        $hotel = $this->hotel->findById($id);
        return view('admin.hotel.setting.form',compact('hotel'));
    }

    public function update(Request $request, $id){
        try {
            $hotel = $this->hotel->findById($id);
            $directMetas = [
                'booking_url', 'street', 'city', 'state', 'postcode'
            ];
            $this->hotelSetting->storeDirectMetas($request, $directMetas, $hotel);
            Toastr::success('Hotel data updated.','Operation Success');
            return redirect()->back();
        }catch (\Exception $e){
            Toastr::error($e->getMessage(), 'Server Error');
            return redirect()->back();
        }
    }
}
