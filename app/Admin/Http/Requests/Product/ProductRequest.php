<?php

namespace App\Admin\Http\Requests\Product;

use App\Admin\Http\Requests\BaseRequest;
use App\Enums\Product\ProductInstock;
use App\Enums\Product\ProductStatus;
use Illuminate\Validation\Rules\Enum;

class ProductRequest extends BaseRequest
{
    public function methodGet(){
        return [

        ];
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPost()
    {
        return [
            'product.name' => ['required', 'string'],
            'product.sku' => ['nullable', 'string'],
            'product.desc' => ['nullable'],
            'categories_id' => ['nullable', 'array'],
            'categories_id.*' => ['nullable', 'exists:App\Models\ProductCategory,id'],
            'product.feature_image' => ['required'],
            'product.price' => ['required', 'numeric'],
            'product.price_promotion' => ['nullable', 'numeric'],
            'product.in_stock' => ['required', new Enum(ProductInstock::class)],
            'product.status' => ['required', new Enum(ProductStatus::class)],
            'product.gallery' => ['nullable']
        ];
    }

    protected function methodPut()
    {
        return [
            'product.id' => ['required', 'exists:App\Models\Product,id'],
            'product.name' => ['required', 'string'],
            'product.sku' => ['nullable', 'string'],
            'product.desc' => ['nullable'],
            'categories_id' => ['nullable', 'array'],
            'categories_id.*' => ['nullable', 'exists:App\Models\ProductCategory,id'],
            'product.feature_image' => ['required'],
            'product.price' => ['required', 'numeric'],
            'product.price_promotion' => ['nullable', 'numeric'],
            'product.in_stock' => ['required', new Enum(ProductInstock::class)],
            'product.status' => ['required', new Enum(ProductStatus::class)],
            'product.gallery' => ['nullable']
        ];
        
    }
}