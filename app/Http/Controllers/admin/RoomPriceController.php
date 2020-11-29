<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Repositories\hotel\HotelInterface;
use App\Repositories\roomType\RoomTypeInterface;
use Carbon\CarbonPeriod;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class RoomPriceController extends Controller
{
    protected $roomType, $hotel;
    public function __construct(RoomTypeInterface $roomType, HotelInterface $hotel)
    {
        $this->roomType = $roomType;
        $this->hotel = $hotel;
    }

    public function index(){
        $months=[];
        for($m=1; $m<=12; ++$m){
            $months[] = date('F', mktime(0, 0, 0, $m, 1));
        }
        $hotel = $this->hotel->getAuthHotel();
        return view('admin.roomPrices.index', compact('hotel'));
    }

    public function loadCalendar(Request $request){
        $hotel_id = $request->hotel_id;
        $hotel = $this->hotel->findById($hotel_id);
        $roomTypes = $this->hotel->activeRoomTypes($hotel);
        if($request->startDate != null && $request->endDate != null){
            $startDate = new Carbon($request->startDate);
            $endDate = new Carbon($request->endDate);
        }else {
            $startDate = Carbon::now()->subDays(5);
            $endDate = Carbon::now()->addDays(10);
        }
//        dd($today);
        $period = CarbonPeriod::create($startDate, $endDate);
        $view = view('admin.roomPrices.calendar',compact('period','roomTypes'))->render();
        return response()->json($view,200);
    }
}
