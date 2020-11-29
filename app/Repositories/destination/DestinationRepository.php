<?php

namespace App\Repositories\destination;

use App\Model\Destination;

class DestinationRepository implements DestinationInterface{

    public function getAll()
    {
        return Destination::all();
    }

    public function activeDestinations(){
        return Destination::where('status','Active')->with('hotels')->get();
    }

    public function destinationHasHotels(){
        $destinations = $this->activeDestinations()->filter(function ($destination) {
            return $destination->hotels->count() > 0;
        });
        return $destinations;
    }

    public function store($request)
    {
        $destination = Destination::create([
            'destination' => $request['destination'],
            'status' => $request['status'] == "on" ? "Active" : "InActive",
        ]);
        return $destination;
    }

    public function findById($id)
    {
        return Destination::where('id',$id)->first();
    }

    public function update($editDestination, $request = [])
    {
        $editDestination->update([
            'destination' => $request['destination'],
            'status' => $request['status'] == "on" ? "Active" : "InActive",
        ]);
        return $editDestination;
    }

    public function delete($destination)
    {
        if($destination->hotels->count() > 0 ){
            return [
                'code' => '500',
                'msg' => 'Cannot delete destination. Remove associated hotels first.'
            ];
        }else{
            $destination->delete();
            return [
                'code' => '200',
                'msg' => 'Destination Delete Successfully'
            ];
        }
    }
}
