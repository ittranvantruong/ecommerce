<?php

namespace App\Api\V1\Http\Resources\ProductCategory;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AllProductCategoryTreeResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return $this->collection->map(function($category){
            
            return $this->recursive($category);
            
        });
    }

    private function recursive($category){
        $data = [
            'id' => $category->id,
            'name' => $category->name,
            'slug' => $category->slug,
            'feature_image' => asset($category->feature_image)
        ];
        if($category->children && $category->children->count() > 0){
            $data['children'] = $category->children->map(function($category){
                return $this->recursive($category);
            });
        }
        return $data;
    }
}
