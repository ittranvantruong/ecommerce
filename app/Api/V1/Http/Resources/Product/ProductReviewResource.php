<?php

namespace App\Api\V1\Http\Resources\Product;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductReviewResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return $this->collection->map(function($review){
            return [
                'id' => $review->id,
                'fullname' => optional($review->user)->fullname,
                'avatar' => asset(optional($review->user)->avatar),
                'content' => $review->content,
                'rating' => $review->rating
            ];
        });
    }
}