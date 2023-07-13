<?php

namespace App\Api\V1\Http\Resources\Product;

use Illuminate\Http\Resources\Json\JsonResource;

class ShowProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'in_stock' => $this->in_stock,
            'feature_image' => asset($this->feature_image),
            'gallery' => $this->gallery ? array_map(function($value){
                return asset($value);
            }, $this->gallery->toArray()) : [],
            'desc' => $this->desc,
            'price' => $this->price,
        ];
        if($this->price_promotion){
            $data['price_promotion'] = $this->price_promotion;
        }
        return $data;
    }
}
