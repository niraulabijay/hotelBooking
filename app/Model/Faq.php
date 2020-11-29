<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $table = "faqs";

    protected $fillable = [
        'question', 'answer', 'faq_category_id'
    ];

    public function category(){
        return $this->belongsTo(FaqCategory::class,'faq_category_id');
    }

}
