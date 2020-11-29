<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Model\BrandSetting;
use App\Repositories\brand\BrandInterface;
use App\Repositories\brand\BrandSettingInterface;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class BrandSettingController extends Controller
{
    private $baseView = 'admin.brand.setting.';

    public function __construct(BrandInterface $brandRepo, BrandSettingInterface $brandSettingRepo)
    {
        $this->brandRepo = $brandRepo;
        $this->brandSettingRepo = $brandSettingRepo;
    }

    public function index($slug){
        $brand = $this->brandRepo->findBySlug($slug);
        return view($this->baseView.'form', compact('brand'));
    }

    public function update(Request $request){
//         dd($request);
         try {
            $this->brandSettingRepo->updateService($request->brand_id, $request);
            $this->brandSettingRepo->updateExperience($request->brand_id, $request);
            $this->brandSettingRepo->updateBanner($request->brand_id, $request);
            Toastr::success('Brand Details Updated.', 'Operation Success');
            return redirect()->back();
         }catch (\Exception $e){
             Toastr::error($e->getMessage(),'Server Error');
             return redirect()->back();
         }
    }
}
