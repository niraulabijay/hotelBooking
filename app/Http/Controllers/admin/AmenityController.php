<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Amenity\StoreAmenity;
use App\Http\Requests\Amenity\UpdateAmenity;
use App\Repositories\amenity\AmenityInterface;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Mockery\Exception;

class AmenityController extends Controller
{
    protected $amenity;
    public function __construct(AmenityInterface $amenity)
    {
        $this->amenity = $amenity;
    }

    public function index(){
        $amenities = $this->amenity->getAll();
        return view('admin.amenity.index', compact('amenities'));
    }

    public function store(StoreAmenity $request){
//        dd($request);
        try{
            $amenity = $this->amenity->storeAmenity($request->only(['title','icon','description','status']));
            $this->amenity->storeIcon($amenity, $request->icon);
            Toastr::success('New Amenity "'.$amenity->title.'" added','Operation Success');
            return redirect()->back();
        }catch (\Exception $e){
            Toastr::error($e->getMessage(),'Operation Failed');
            return redirect()->back();
        }
    }

    public function edit($slug){
        $editAmenity = $this->amenity->findBySlug($slug);
        $amenities = $this->amenity->getAll();
        return view('admin.amenity.index', compact('amenities','editAmenity'));

    }

    public function update(UpdateAmenity $request){
        try {
            $amenity = $this->amenity->findById($request->amenity_id);
            $amenity = $this->amenity->updateAmenity($amenity, $request->only(['title', 'status', 'description']));
            $this->amenity->storeIcon($amenity, $request->icon);
            Toastr::success('Amenity "'.$amenity->title.'" updated','Operation Success');
            return redirect()->route('admin.amenities');
        }catch (\Exception $e){
            Toastr::error($e->getMessage(),'Operation Failed');
            return redirect()->back();
        }
    }

    public function delete($id){
        try{
            $amenity = $this->amenity->findById($id);
            $this->amenity->destroyAmenity($amenity);
            Toastr::success('Amenity  deleted','Operation Success');
            return redirect()->route('admin.amenities');
        }catch(Exception $e){
            Toastr::error($e->getMessage(),'Operation Failed');
            return redirect()->back();
        }
    }

}
