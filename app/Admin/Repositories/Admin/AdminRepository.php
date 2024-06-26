<?php

namespace App\Admin\Repositories\Admin;
use App\Admin\Repositories\EloquentRepository;
use App\Admin\Repositories\Admin\AdminRepositoryInterface;
use App\Models\Admin;

class AdminRepository extends EloquentRepository implements AdminRepositoryInterface
{

    protected $select = [];

    public function getModel(){
        return Admin::class;
    }

    public function searchAllLimit($keySearch = '', $meta = [], $select = ['id', 'fullname', 'phone'], $limit = 10){
        $this->instance = $this->model->select($select);
        $this->getQueryBuilderFindByKey($keySearch);
        
        foreach($meta as $key => $value){
            $this->instance = $this->instance->where($key, $value);
        }
        return $this->instance->limit($limit)->get();
    }

    protected function getQueryBuilderFindByKey($key){
        $this->instance = $this->instance->where(function($query) use ($key){
            return $query->where('username', 'LIKE', '%'.$key.'%')
            ->orWhere('phone', 'LIKE', '%'.$key.'%')
            ->orWhere('email', 'LIKE', '%'.$key.'%')
            ->orWhere('fullname', 'LIKE', '%'.$key.'%');
        });
    }
    public function getQueryBuilderFollowRole(){
        $this->getQueryBuilderOrderBy();
        $this->instance = $this->instance->whereIn('roles', auth('admin')->user()->roles->listRolesAdminAfterCase());
        return $this->instance;
    }
    public function getQueryBuilderOrderBy($column = 'id', $sort = 'DESC'){
        $this->getQueryBuilder();
        $this->instance = $this->instance->orderBy($column, $sort);
        return $this->instance;
    }
}