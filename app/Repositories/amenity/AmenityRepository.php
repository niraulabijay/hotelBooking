<?php

namespace App\Repositories\amenity;


use App\Model\Amenity;
use Illuminate\Support\Facades\DB;

class AmenityRepository implements AmenityInterface
{
    public function getAll()
    {
        return Amenity::all();
    }

    public function findById($id){
        return Amenity::find($id);
    }

    public function findBySlug($slug)
    {
        return Amenity::where('slug',$slug)->first();
    }

    public function storeAmenity($request = [])
    {
        return Amenity::create([
            'title'=>$request['title'] ?? '',
            'description'=>$request['description'] ?? '',
            'status'=>$request['status'] == "on" ? 'Active' : 'InActive',
        ]);
    }

    public function storeIcon($amenity, $icon)
    {
        $amenity->iconable()->updateOrCreate([], [
            'icon' => $icon,
            'title' => $amenity->title,
        ]);
    }

    public function updateAmenity($amenity, $request = [])
    {
        $amenity->update([
            'title'=>$request['title'] ?? '',
            'description'=>$request['description'] ?? '',
            'status'=>$request['status'] == "on" ? 'Active' : 'InActive',
        ]);
        return $amenity;
    }

    public function destroyAmenity($amenity)
    {
        DB::beginTransaction();

        try {
            $amenity->delete();

            DB::commit();
            // all good
        } catch (\Exception $e) {
            DB::rollback();
        }
    }
}