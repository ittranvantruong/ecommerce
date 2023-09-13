<?php

namespace App\Api\V1\Repositories\Order;
use App\Admin\Repositories\Order\OrderRepository as AdminOrderRepository;
use App\Api\V1\Repositories\Order\OrderRepositoryInterface;
use App\Enums\Order\OrderStatus;
use Illuminate\Support\Facades\DB;

class OrderRepository extends AdminOrderRepository implements OrderRepositoryInterface
{
    public function createWithDetail(array $data, array $detail){
        
        DB::beginTransaction();
        
        try {
            //code...
            $this->instance = $this->create($data);

            $this->instance->details()->createMany($detail);
            
            DB::commit();
            return $this->instance;
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return false;
        }
        
    }

    public function getByKeyAuthCurrent($filter){
        $this->instance = $this->model->currentAuth()
        ->with('details');
        foreach($filter as $column => $value){
            $this->instance = $this->instance->where($column, $value);
        }
        $this->instance = $this->instance->orderBy('id', 'desc')->get();
        return $this->instance;
    }

    public function findOrFailWithRelations($id, array $relations = ['details']){
        $this->findOrFail($id);
        $this->instance = $this->instance->load($relations);
        return $this->instance;
    }

    public function findOrFail($id){
        $this->instance = $this->model->findOrFail($id);
        
        $this->authorize('view', 'sanctum');

        return $this->instance;
    }

    public function cancel($id){
        $this->findOrFail($id);
        if($this->instance->status == OrderStatus::Processing){
            $this->instance->update([
                'status' => OrderStatus::Cancelled
            ]);
            return $this->instance;
        }
        return false;
    }

}