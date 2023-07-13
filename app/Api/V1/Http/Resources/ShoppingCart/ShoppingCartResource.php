<?php

namespace App\Api\V1\Http\Resources\ShoppingCart;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ShoppingCartResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        return $this->collection->map(function($shoppingCart) {
            $data = [
                'id' => $shoppingCart->id,
                'qty' => $shoppingCart->qty,
                'product' => [
                    'id' => $shoppingCart->product->id,
                    'name' => $shoppingCart->product->name,
                    'slug' => $shoppingCart->product->slug,
                    'in_stock' => $shoppingCart->product->in_stock,
                    'feature_image' => asset($shoppingCart->product->feature_image)
                ]
            ];
            $data['product']['price'] = $shoppingCart->product->price;
            if($shoppingCart->product->price_promotion){
                $data['product']['price_promotion'] = $shoppingCart->product->price_promotion;
            }
            return $data;
        });
    }
}
