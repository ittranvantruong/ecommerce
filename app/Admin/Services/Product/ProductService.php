<?php

namespace App\Admin\Services\Product;

use App\Admin\Services\Product\ProductServiceInterface;
use  App\Admin\Repositories\Product\ProductRepositoryInterface;
use Illuminate\Http\Request;
use App\Admin\Traits\Setup;
use App\Enums\Product\ProductStatus;
use Illuminate\Support\Facades\DB;

class ProductService implements ProductServiceInterface
{
    use Setup;
    /**
     * Current Object instance
     *
     * @var array
     */
    protected $data;
    
    protected $repository;

    public function __construct(
        ProductRepositoryInterface $repository, 
    ){
        $this->repository = $repository;
    }
    
    public function store(Request $request){

        $this->data = $request->validated();
        $this->handleDataProduct();
        DB::beginTransaction();
        try{
            $instance = $this->repository->createWithAllRelations(...$this->data);
            DB::commit();
            return $instance;
        } catch (\Throwable $th) {
            throw $th;
            DB::rollBack();
            return false;
        }
    }
    protected function handleDataProduct(){
        $this->data['product']['gallery'] = $this->data['product']['gallery'] ? explode(",", $this->data['product']['gallery']) : null;     
        $this->data['product']['price_promotion'] = $this->data['product']['price_promotion'] ?? null;
    }
    public function update(Request $request){
        
        $this->data = $request->validated();
        $this->handleDataProduct();

        DB::beginTransaction();
        try{            
            $instance = $this->repository->updateWithAllRelations(...$this->data);
            $this->repository->syncCategories($instance, $this->data['categories_id'] ?? []);

            DB::commit();
            return $instance;
        } catch (\Throwable $th) {
            throw $th;
            DB::rollBack();
            return false;
        }
    }

    public function delete($id){
        return $this->repository->delete($id);
    }

    public function actionMultipleRecode(Request $request){

        $this->data = $request->all();

        if($this->data['action'] == 'delete'){
            
            foreach($this->data['id'] as $value){
                $this->delete($value);
            }
            return true;

        }elseif($this->data['action'] == 'publishedStatus' || $this->data['action'] == 'draftStatus'){

            $this->repository->updateMultipleByIds($this->data['id'], [
                'status' => $this->data['action'] == 'publishedStatus' ? ProductStatus::Published : ProductStatus::Draft
            ]);
            
            return true;
        }

        return false;

    }
}