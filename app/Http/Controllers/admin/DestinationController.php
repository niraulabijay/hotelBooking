<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Repositories\destination\DestinationInterface;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class DestinationController extends Controller
{
    protected $destination;
    public function __construct(DestinationInterface $destination)
    {
        $this->destination = $destination;
    }

    public function index(){
        $destinations = $this->destination->getAll();
        return view('admin.destination.index', compact('destinations'));
    }

    public function store(Request $request){
        try {
            $destination = $this->destination->store($request->all());
            if($destination){
                return redirect()->back()->with('message-success','New destination created.');
            }else{
                return redirect()->back()->with('message-danger','Destination not created');
            }
        }catch (\Exception $e){
            return redirect()->back()->with('message-danger',$e->getMessage());
        }
    }

    public function edit($id){
        $editDestination = $this->destination->findById($id);
        $destinations = $this->destination->getAll();
        return view('admin.destination.index', compact('destinations','editDestination'));
    }

    public function update(Request $request, $id){
        try {
            $editDestination = $this->destination->findById($request->destination_id);
            $editDestination = $this->destination->update($editDestination, $request->all());
            if ($editDestination) {
                return redirect()->back()->with('message-success', 'Destination updated.');
            } else {
                return redirect()->back()->with('message-danger', 'Failed to update destination');
            }
        }catch (\Exception $e){
            return redirect()->back()->with('message-danger',$e->getMessage());
        }
    }

    public function delete($id){
        try {
            $destination = $this->destination->findById($id);
            $result = $this->destination->delete($destination);
            if($result['code'] == '200'){
                Toastr::success($result['message'],"Operation Success");
            }else{
                Toastr::error($result['message'],'Operation Failed');
            }
            return redirect()->back();
        }catch (\Exception $e){
            return redirect()->back()->with('message-danger',$e->getMessage());
        }
    }
}
