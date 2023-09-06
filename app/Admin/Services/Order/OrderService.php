<?php

namespace App\Admin\Services\Order;
use App\Admin\Services\Order\OrderServiceInterface;
use App\Admin\Repositories\Order\{OrderRepositoryInterface, OrderDetailRepositoryInterface};
use App\Admin\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;
use App\Admin\Repositories\Product\ProductRepositoryInterface;
use App\Enums\Order\{OrderStatus, OrderPaymentMethod, OrderShippingMethod};
use Illuminate\Support\Facades\DB;

class OrderService implements OrderServiceInterface
{
    protected $data;
    protected $subTotal;
    protected $orderDetails;
    protected $repository;
    protected $repositoryOrderDetail;
    protected $repositoryUser;
    protected $repositoryProduct;

    public function __construct(
        OrderRepositoryInterface $repository,
        OrderDetailRepositoryInterface $repositoryOrderDetail,
        UserRepositoryInterface $repositoryUser,
        ProductRepositoryInterface $repositoryProduct
    )
    {
        $this->repository = $repository;
        $this->repositoryOrderDetail = $repositoryOrderDetail;
        $this->repositoryUser = $repositoryUser;
        $this->repositoryProduct = $repositoryProduct;
    }

    public function store(Request $request){
        $this->data = $request->validated();
        $this->data['order']['discount'] = 0;
        $this->data['order']['payment_method'] = OrderPaymentMethod::COD;
        $this->data['order']['shipping_method'] = OrderShippingMethod::Road;
        $this->data['order']['status'] = OrderStatus::Processing;
        DB::beginTransaction();
        try {
            if(!$this->makeNewDataOrderDetail()){
                return false;
            }
            $this->data['order']['sub_total'] = $this->data['order']['total'] = $this->subTotal;
            $order = $this->repository->create($this->data['order']);
            $this->storeOrderDetail($order->id, $this->orderDetails);
            DB::commit();
            return $order;
        } catch (\Throwable $th) {
            // throw $th;
            DB::rollBack();
            return false;
        }
    }
    private function makeNewDataOrderDetail(){
        $products = $this->repositoryProduct->getByIdsAndOrderByIds(
            array_unique($this->data['order_detail']['product_id'])
        );
        if($products->count() == 0){
            return false;
        }
        $this->dataOrderDetail($products);
        return true;
    }
    private function dataOrderDetail($products){
        foreach($this->data['order_detail']['product_id'] as $key => $value){
            $product = $products->firstWhere('id', $value);
            $unitPrice = $product->price_promotion ?: $product->price;
            $this->orderDetails[] = [
                'product_id' => $product->id,
                'unit_price' => $unitPrice,
                'qty' => $this->data['order_detail']['product_qty'][$key],
                'detail' => [
                    'product' => $product
                ]
            ];
            $this->subTotal += $unitPrice * $this->data['order_detail']['product_qty'][$key];
        }
    }

    protected function storeOrderDetail($orderId, $data){
        foreach($data as $item){
            $item['order_id'] = $orderId;
            $this->repositoryOrderDetail->create($item);
        }
    }

    public function update(Request $request){
        $this->data = $request->validated();
        
        DB::beginTransaction();
        try {
            $order = $this->repository->update($this->data['order']['id'], $this->data['order']);
            DB::commit();
            return $order;
        } catch (\Throwable $th) {
            // throw $th;
            DB::rollBack();
            return false;
        }
    }

    private function updateOrCreateDataOrderDetail(){
        $data = [];
        foreach($this->data['order_detail']['id'] as $key => $value){
            if($value == 0){
                $data['product_id'][] = $this->data['order_detail']['product_id'][$key];
                $data['product_qty'][] = $this->data['order_detail']['product_qty'][$key];
            }else{
                $orderDetail = $this->repositoryOrderDetail->update($value, [
                    'qty' => $this->data['order_detail']['product_qty'][$key]]
                );
                $this->subTotal += $orderDetail->unit_price * $orderDetail->qty;
            }
        }
        return $data;
    }

    public function delete($id){
        return $this->repository->delete($id);
    }

    public function addProduct(Request $request){
        $data = $request->validated();
        $product = $this->repositoryProduct->findOrFail($data['product_id']);
        return $product;
    }
    
    public function calculateTotal(Request $request){
        $data = $request->validated('order_detail');
        $total = 0; $product = [];
        foreach($data['product_id'] as $key => $value){
            $product[] = [
                'id' => $value,
                'qty' => $data['product_qty'][$key]
            ];
        }
        if(!empty($product)){
            $total += $this->totalPrice(
                $this->repositoryProduct->getByIdsAndOrderByIds(array_column($product, 'id')),
                array_column($product, 'qty')
            );
        }
        return $total;
    }

    public function totalPrice($collect, $qty){
        $total = 0;
        $total += $collect->mapWithKeys(function($item, $key) use ($qty) {
            $price = ($item->price_promotion ?: $item->price) * $qty[$key];
            return [$item->id => $price];
        })->sum();
        return $total;
    }
}