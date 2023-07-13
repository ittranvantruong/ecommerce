<?php

namespace App\Admin\Repositories\User;
use App\Admin\Repositories\EloquentRepository;
use App\Admin\Repositories\User\UserLevelRepositoryInterface;
use App\Models\UserLevel;

class UserLevelRepository extends EloquentRepository implements UserLevelRepositoryInterface
{

    public function getModel(){
        return UserLevel::class;
    }

    public function getQueryBuilderOrderBy($column = 'position', $sort = 'ASC'){
        $this->getQueryBuilder();
        $this->instance = $this->instance->orderBy($column, $sort);
        return $this->instance;
    }
}