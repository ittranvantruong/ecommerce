<tr @class([
    'item-product',
    'product-'.$product->id
])>
    <td class="align-middle">
        <span class="cursor-pointer remove-item-product" data-id="0"><i class="ti ti-x"></i></span>
        <x-input type="hidden" name="order_detail[id][]" value="0" />
        <x-input type="hidden" name="order_detail[product_id][]" :value="$product->id" />
    </td>
    <td class="align-middle">
        <x-link :href="route('admin.product.edit', $product->id)" target="_blank" :title="$product->name" />
    </td>
    <td class="text-center">
        <x-input type="number" name="order_detail[product_qty][]" value="1" min="1" autocomplete="off"
        :data-parsley-number-message="__('Trường này phải là số.')"
        :data-parsley-min-message="__('Giá trị phải lớn hơn 1.')"/>
    </td>
    <td class="unit-price align-middle">{{ format_price($product->price_promotion ?? $product->price) }}</td>
    <td class="total-price align-middle">{{ format_price($product->price_promotion ?? $product->price) }}</td>
</tr>