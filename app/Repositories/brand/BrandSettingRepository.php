<?php

namespace App\Repositories\brand;

use App\Model\Brand;
use App\Model\BrandSetting;

class BrandSettingRepository implements BrandSettingInterface{

    public function create($data){
        return BrandSetting::create($data);
    }

    public function createUpdate($data, $matches){
        return BrandSetting::updateOrCreate($matches, $data);
    }

    public function updateService($brand_id, $request){
        $oldData = isset($request->service_old) ? (array_keys($request->service_old) ?? []) : [];
        if(count($oldData) > 0)
            $this->updateOldService($request, $oldData);
        $brandServices = $this->brandServices($brand_id)->whereNotIn('id',$oldData)->whereNotIn('parent',$oldData);
        foreach($brandServices as $service)
            $service->delete();
        $keys = isset($request->service_title) ? array_keys($request->service_title) ?? [] : [];
        $keys = array_diff($keys, $oldData);
        foreach($keys as $key){
            $service = $this->create([
                'brand_id'=>$brand_id,
                'key' => 'service_title',
                'value' => $request->service_title[$key],
            ]);
            $description = $this->create([
                'brand_id'=>$brand_id,
                'key' => 'service_description',
                'value' => $request->service_description[$key],
                'parent' => $service->id,
            ]);
            if($request->hasFile('service_image')){
                $image = $request->file('service_image')[$key] ?? null;
                $this->spatieImage($service, $image, 'image');
            }
        }
    }

    private function spatieImage($model, $image, $collectionName){
        if($image){
            $model->addMedia($image)->toMediaCollection($collectionName);
        }
    }

    private function updateOldService($request, $oldData){
        foreach($oldData as $id){
            $oldService = BrandSetting::find($id);
            $oldService->update([
                'value' => $request->service_title[$id],
            ]);
            $description = BrandSetting::where('brand_id',$request->brand_id)->where('key','service_description')->where('parent',$id)->first();
            $description->update([
                'value' => $request->service_description[$id],
            ]);
            $image = $request->file('service_image')[$id] ?? null;
            $this->spatieImage($oldService, $image, 'image');
        }
    }

    public function brandServices($brand_id){
        return BrandSetting::where('brand_id',$brand_id)
            ->whereIn('key',['service_title','service_description'])
            ->get();
    }

    public function updateExperience($brand_id, $request){
        $matches = ['brand_id'=>$brand_id ,'key'=>'experience'];
        $experience = $this->createUpdate([
            'brand_id'=>$brand_id,
            'key' => 'experience',
            'value' => $request->experience_description,
        ],$matches);
        $image = $request->file('experience_image') ?? null;
        $this->spatieImage($experience, $image, 'image');
    }

    public function updateBanner($brand_id, $request){
        $matches = ['brand_id'=>$brand_id ,'key'=>'banner'];
        $banner = $this->createUpdate([
            'brand_id'=>$brand_id,
            'key' => 'banner',
            'value' => $request->banner_text,
        ],$matches);
        $image = $request->file('banner_image') ?? null;
        $this->spatieImage($banner, $image, 'image');
    }
}
