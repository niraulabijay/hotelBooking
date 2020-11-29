<?php

namespace App\Http\Resources\faq;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\faq\FaqResource;

class FaqCategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'questions' => FaqResource::collection($this->faqs),
        ];
    }
}
