<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\destination\DestinationResource;
use App\Http\Resources\faq\FaqCategoryResource;
use App\Model\FaqCategory;
use App\Repositories\destination\DestinationInterface;
use App\Repositories\faq\FaqInterface;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    protected $destination, $faq;
    public function __construct(DestinationInterface $destinationRepository, FaqInterface $faqRepository)
    {
        $this->destination = $destinationRepository;
        $this->faq = $faqRepository;
    }
    public function destinations(){
        $destinations = $this->destination->destinationHasHotels();
        return [
            'status' => 'success',
            'destinations' => DestinationResource::collection($destinations)
        ];
    }

    public function faqs(){
        $faqCatQuestions = FaqCategoryResource::collection($this->faq->faqWithQues());
        return [
            'status' => 'success',
            'categories' => $faqCatQuestions,
        ];
    }
}
