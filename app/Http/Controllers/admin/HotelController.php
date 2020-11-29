<?php

namespace App\Http\Controllers\admin;

use App\Model\Brand;
use App\Model\Hotel;
use App\Http\Controllers\Controller;
use App\Repositories\destination\DestinationInterface;
use App\Repositories\hotel\HotelInterface;
use App\tableList;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;

class HotelController extends Controller
{
    protected $destination, $hotel;
    public function __construct(HotelInterface $hotel, DestinationInterface $destination)
    {
        $this->destination= $destination;
        $this->hotel= $hotel;
    }

    public function index(){
        $hotels = Hotel::all();
        $brands = Brand::all();
        $destinations = $this->destination->getAll();
        return view('admin.hotel.index',compact('hotels','brands','destinations'));
    }

    public function add(Request $request){
        // dd($request);
        $request->validate([
            'title' => 'required|unique:hotels,title',
            'brand' => 'required',
            'feature' => 'required|mimes:jpeg,bmp,png',
            'destination' => 'required',
        ]);
        try{
            $hotel = new Hotel();
            $hotel->title = $request->title;
            $hotel->brand_id = $request->brand;
            $hotel->destination_id = $request->destination;
            if($request->status){
                $hotel->status = "Active";
            }else{
                $hotel->status = "Inactive";
            }
            $hotel->save();
            if($request->hasFile('feature')){
                $hotel->addMediaFromRequest('feature')
                    ->toMediaCollection('hotel_feature');
            }
        }catch(\Exception $e){
            Toastr::error($e->getMessage(), 'Server Error');
            return redirect()->back();
        }
        Toastr::success('New Hotel Added Successfully','Operation Success');
        return redirect()->back();
    }

    public function edit($id){
        $hotels = Hotel::all();
        $brands = Brand::all();
        $destinations = $this->destination->getAll();
        $editHotel = Hotel::findOrFail($id);
        return view('admin.hotel.index',compact('hotels','editHotel','brands','destinations'));
    }

    public function update(Request $request, $id){
        $request->validate([
            'title' => 'required|unique:hotels,title,'.$request->id.',id',
            'brand' => 'required',
            'feature' => 'mimes:jpeg,bmp,png',
            'destination' => 'required'
        ]);
        try{
            $hotel = Hotel::find($request->id);
            $hotel->title = $request->title;
            $hotel->brand_id = $request->brand;
            $hotel->destination_id = $request->destination;
            if($request->status){
                $hotel->status = "Active";
            }else{
                $hotel->status = "Inactive";
            }
            $hotel->save();
            if($request->hasFile('feature')){
                $hotel->addMediaFromRequest('feature')
                    ->toMediaCollection('hotel_feature');
            }
        }catch(\Exception $e){
            Toastr::error($e->getMessage(), 'Server Error');
            return redirect()->back();
        }
        return redirect()->route('admin.hotels')->with('sweetAlert-success','Hotel Updated Successfully');
    }

    public function delete(Request $request){
        $id_key = 'hotel_id';

        $tables = tableList::getTableList($id_key);
        $hotel = Hotel::find($request->hotel_id);
        try {
            $delete_query = $hotel->delete();
            if ($delete_query) {
                Toastr::success('Hotel has been deleted successfully', 'Operation Success');
                return redirect()->back();
            } else {
                Toastr::error('Something went wrong.', 'Failed to Delete');
                return redirect()->back();
            }

        } catch (\Illuminate\Database\QueryException $e) {
            $msg = 'This data already used in  : ' . $tables . ' Please remove those data first';
            Toastr::error($msg, 'Operation Failed');
            return redirect()->back();
        } catch (\Exception $e) {
            Toastr::error($e->getMessage(), 'Server Error');
            return redirect()->back();
        }

    }
}
