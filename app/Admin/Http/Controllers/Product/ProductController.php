<?php

namespace App\Admin\Http\Controllers\Product;

use App\Admin\Http\Controllers\Controller;
use App\Admin\Http\Requests\Product\ProductRequest;
use App\Admin\Repositories\Product\ProductRepositoryInterface;
use App\Admin\Services\Product\ProductServiceInterface;
use App\Admin\DataTables\Product\ProductDataTable;
use App\Admin\Repositories\ProductCategory\ProductCategoryRepositoryInterface;
use App\Enums\Product\{ProductInstock, ProductPurchaseQtyType, ProductStatus};
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $repositoryCategory;
    protected $repositoryAttribute;

    public function __construct(
        ProductRepositoryInterface $repository, 
        ProductCategoryRepositoryInterface $repositoryCategory, 
        ProductServiceInterface $service
    ){
        parent::__construct();
        $this->repository = $repository;
        $this->repositoryCategory = $repositoryCategory;
        $this->service = $service;
    }

    public function getView(){
        return [
            'index' => 'admin.products.index',
            'create' => 'admin.products.create',
            'edit' => 'admin.products.edit',
            'search_render_list' => 'admin.orders.partials.list-search-result-product'
        ];
    }

    public function getRoute(){
        return [
            'index' => 'admin.product.index',
            'create' => 'admin.product.create',
            'edit' => 'admin.product.edit',
            'delete' => 'admin.product.delete'
        ];
    }
    public function index(ProductDataTable $dataTable){
        $actionMultiple = [
            'delete' => 'Xoá',
            'publishedStatus' => 'Đã xuất bản',
            'draftStatus' => 'Bản nháp'
        ];
        return $dataTable->render($this->view['index'], [
            'actionMultiple' => $actionMultiple
        ]);
    }

    public function create(){
        $productCategories = $this->repositoryCategory->getFlatTree();
        return view($this->view['create'], 
            [
                'status' => ProductStatus::asSelectArray(),
                'product_categories' => $productCategories,
                'in_stock' => ProductInstock::asSelectArray()
            ]
        );
    }

    public function store(ProductRequest $request){

        $instance = $this->service->store($request);
        if($instance){
            return to_route($this->route['edit'], $instance->id);
        }
        return back()->with('error', __('notifyFail'))->withInput();
    }

    public function edit($id, Request $request){
        
        $product = $this->repository->loadRelations($this->repository->findOrFail($id), [
            'categories:id'
        ]);
        $productOfCategory = $product->categories->pluck('id')->toArray();
        $productCategories = $this->repositoryCategory->getFlatTree();
        return view(
            $this->view['edit'],
            [
                'product' => (object)$product->toArray($request),
                'product_of_category' => $productOfCategory,
                'status' => ProductStatus::asSelectArray(),
                'product_categories' => $productCategories,
                'in_stock' => ProductInstock::asSelectArray()
            ]
        );
    }
 
    public function update(ProductRequest $request){

        $instance = $this->service->update($request);

        if($instance){
            return back()->with('success', __('notifySuccess'));
        }
        return back()->with('error', __('notifyFail'));

    }

    public function delete($id){

        $this->service->delete($id);
        
        return to_route($this->route['index'])->with('success', __('notifySuccess'));
        
    }

    public function searchRenderProduct(ProductRequest $request){
        $products = $this->repository->getByColumnsWithRelationsLimit([
            'name' => $request->input('key')
        ]);
        return view($this->view['search_render_list'], compact('products'));
    }

    public function actionMultipleRecode(Request $request){
        $boolean = $this->service->actionMultipleRecode($request);
        if($boolean){
            return back()->with('success', __('notifySuccess'));
        }
        return back()->with('error', __('notifyFail'));
    }
    
}