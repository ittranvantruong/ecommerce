<?php

namespace App\Api\V1\Http\Controllers\Order;

use App\Admin\Http\Controllers\Controller;
use App\Api\V1\Services\Order\OrderServiceInterface;
use App\Api\V1\Repositories\Order\OrderRepositoryInterface;
use App\Api\V1\Http\Requests\Order\OrderRequest;
use App\Api\V1\Http\Resources\Order\AllOrderResource;
use App\Api\V1\Http\Resources\Order\ShowOrderResource;

/**
 * @group Đơn hàng
 */

class OrderController extends Controller
{

    public function __construct(
        OrderRepositoryInterface $repository,
        OrderServiceInterface $service
    )
    {
        $this->repository = $repository;
        $this->service = $service;
    }
    /**
     * Danh sách đơn hàng
     *
     * Lấy danh sách đơn hàng của user.
     *
     * @headersParam X-TOKEN-ACCESS string
     * token để lấy dữ liệu. Example: ijCCtggxLEkG3Yg8hNKZJvMM4EA1Rw4VjVvyIOb7
     * 
     * @queryParam status integer
     * trạng thái đơn hàng: 1: đang xử lý; 2: đã xử lý; 3: đã hoàn thành; 4: đã hủy. Example: 1
     * 
     * 
     * @authenticated
     * 
     * @response 200 {
     *      "status": 200,
     *      "message": "Thực hiện thành công.",
     *      "data": [
     *         {
     *          "id": 4,
     *          "total": 2970000,
     *          "status": 1,
     *          "created_at": "2023-04-05T02:31:15.000000Z",
     *          "products": {
     *              "id": 2,
     *              "name": "Iphone 15",
     *              "qty": 15,
     *              "unit_price": 2000000,
     *              "slug": "iphone-15",
     *              "feature_image": "http:/domain.com/public/assets/images/default-image.png"
     *          }
     *          }
     *      ]
     * }
     *
     * @param  \Illuminate\Http\Request  $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function index(OrderRequest $request){
        $filter = $request->validated();
        $orders = $this->repository->getByKeyAuthCurrent($filter);
        $orders = new AllOrderResource($orders);
        return response()->json([
            'status' => 200,
            'message' => __('notifySuccess'),
            'data' => $orders
        ]);
    }
    /**
     * Chi tiết đơn hàng
     *
     * Lấy chi tiết đơn hàng của user.
     *
     * @headersParam X-TOKEN-ACCESS string
     * token để lấy dữ liệu. Example: ijCCtggxLEkG3Yg8hNKZJvMM4EA1Rw4VjVvyIOb7
     * 
     * @pathParam id integer required
     * id của đơn hàng. Example: 1
     * 
     * 
     * @authenticated
     * 
     * @response 200 {
     *      "status": 200,
     *      "message": "Thực hiện thành công.",
     *      "data": {
     *           "id": 6,
     *           "customer_fullname": "Truong",
     *           "customer_phone": "0999999999",
     *           "customer_email": "truonng@gmail.com",
     *           "shipping_address": "998",
     *           "sub_total": 3188000,
     *           "discount": 0,
     *           "total": 3188000,
     *           "status": 1,
     *           "note": null,
     *           "created_at": "2023-04-05T02:31:15.000000Z",
     *           "details":[
     *              {
     *               "id": 2,
     *              "name": "Iphone 15",
     *              "qty": 5,
     *              "unit_price": 2000000,
     *              "unit_price_purchase_qty": 9000000,
     *              "slug": "iphone-15",
     *              "feature_image": "http:/domain.com/public/assets/images/default-image.png"
     *           }
     *           ]
     *      }
     * }
     *
     * @param  \Illuminate\Http\Request  $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        $order = $this->repository->findOrFailWithRelations($id, ['details']);
        $order = new ShowOrderResource($order);
        return response()->json([
            'status' => 200,
            'message' => __('notifySuccess'),
            'data' => $order
        ]);
    }

    /**
     * Tạo đơn hàng
     *
     * Tạo đơn hàng của user.
     *
     * @headersParam X-TOKEN-ACCESS string
     * token để lấy dữ liệu. Example: ijCCtggxLEkG3Yg8hNKZJvMM4EA1Rw4VjVvyIOb7
     * 
     * @bodyParam customer_fullname string required
     * Họ và tên khách hàng. Example: Nguyen Van A
     * 
     * @bodyParam customer_phone phone required
     * Số điện thoại. Example: 0999999999
     * 
     * @bodyParam customer_email email required
     * Email của khách hàng. Example: example@gmail.com
     * 
     * @bodyParam shipping_address string required
     * Địa chỉ giao hàng. Example: 998 Quang trung, GV
     * 
     * @bodyParam note string
     * Ghi chú KH. Example: Giao trước t7
     * 
     * @authenticated
     * 
     * @response 200 {
     *      "status": 200,
     *      "message": "Thực hiện thành công.",
     *       "data": {
     *           "order_id": 5
     *       }
     * }
     *
     * @param  \Illuminate\Http\Request  $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function store(OrderRequest $request){
        $response = $this->service->store($request);
        if($response){
            return response()->json([
                'status' => 200,
                'message' => __('notifySuccess'),
                'data' => [
                    'order_id' => $response->id
                ]
            ]);
        }
        return response()->json([
            'status' => 400,
            'message' => __('orderNoDataShoppingCart')
        ], 400);
    }

    /**
     * Hủy đơn hàng
     *
     * Hủy đơn hàng của user.
     *
     * @headersParam X-TOKEN-ACCESS string
     * token để lấy dữ liệu. Example: ijCCtggxLEkG3Yg8hNKZJvMM4EA1Rw4VjVvyIOb7
     * 
     * @pathParam id integer required
     * id đơn hàng. Example: 1
     * 
     * 
     * @authenticated
     * 
     * @response 200 {
     *      "status": 200,
     *      "message": "Thực hiện thành công."
     * }
     *
     * @param  \Illuminate\Http\Request  $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function cancel($id){
        $response = $this->service->cancel($id);
        if($response){
            return response()->json([
                'status' => 200,
                'message' => __('notifySuccess')
            ]);
        }
        return response()->json([
            'status' => 400,
            'message' => __('notifyFail')
        ], 400);
    }
}
