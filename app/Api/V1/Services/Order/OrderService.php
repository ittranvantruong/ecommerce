<?php

namespace App\Api\V1\Services\Order;

use App\Api\V1\Services\Order\OrderServiceInterface;
use App\Api\V1\Repositories\Order\{OrderRepositoryInterface, OrderDetailRepositoryInterface};
use App\Api\V1\Repositories\ShoppingCart\ShoppingCartRepositoryInterface;
use App\Api\V1\Repositories\User\UserRepositoryInterface;
use App\Enums\Order\{OrderPaymentMethod, OrderShippingMethod, OrderStatus};
use Illuminate\Http\Request;

class OrderService implements OrderServiceInterface
{
    /**
     * Current Object instance
     *
     * @var array
     */
    protected $data;
    
    protected $repository;
    protected $repositoryOrderDetail;
    protected $repositoryShoppingCart;
    protected $subTotal = 0;
    protected $orderDetail = [];
    protected $repositoryUser;

    public function __construct(
        OrderRepositoryInterface $repository,
        OrderDetailRepositoryInterface $repositoryOrderDetail,
        ShoppingCartRepositoryInterface $repositoryShoppingCart,
        UserRepositoryInterface $repositoryUser
    ){
        $this->repository = $repository;
        $this->repositoryOrderDetail = $repositoryOrderDetail;
        $this->repositoryUser = $repositoryUser;
        $this->repositoryShoppingCart = $repositoryShoppingCart;
    }
    
    public function store(Request $request){
        $this->data = $request->validated();
        $this->data['user_id'] = auth()->user()->id;
        $this->data['discount'] = 0;
        $this->data['payment_method'] = OrderPaymentMethod::COD;
        $this->data['shipping_method'] = OrderShippingMethod::Road;
        $this->data['status'] = OrderStatus::Processing;
        
        $makeData = $this->getDataFromShoppingCart();
        
        if(!$makeData){
            return false;
        }

        $this->data['sub_total'] = $this->subTotal;
            
        $this->data['total'] = $this->data['sub_total'] + $this->data['discount'];
        
        $order = $this->repository->createWithDetail($this->data, $this->orderDetail);

        if($order){
            $this->repositoryShoppingCart->deleteAllCurrentAuth();
        }

        return $order;
    }

    public function update(Request $request){
        
        $this->data = $request->validated();


    }
    public function cancel($id){

        return $this->repository->cancel($id);

    }

    public function delete($id){
        return $this->repository->delete($id);
    }

    protected function storeOrderDetail($orderId, $data){
        foreach($data as $item){
            $item['order_id'] = $orderId;
            $this->repositoryOrderDetail->create($item);
        }
    }

    protected function getDataFromShoppingCart(){
        $shoppingCarts = $this->repositoryShoppingCart->getAuthCurrent();
        if($shoppingCarts->count() == 0){
            return false;
        }

        $shoppingCarts->map(function($shoppingCart){

            $unitPrice = $shoppingCart->product->price_promotion ?: $shoppingCart->product->price;
            $this->orderDetail[] = [
                'product_id' => $shoppingCart->product_id,
                'unit_price' => $unitPrice,
                'qty' => $shoppingCart->qty,
                'detail' => [
                    'product' => $shoppingCart->product
                ]
            ];
            $this->subTotal += $unitPrice * $shoppingCart->qty;
        });
        return true;
    }
}