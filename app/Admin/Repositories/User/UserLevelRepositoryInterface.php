<?php

namespace App\Admin\Repositories\User;

use App\Admin\Repositories\EloquentRepositoryInterface;

interface UserLevelRepositoryInterface extends EloquentRepositoryInterface
{
	public function getQueryBuilderOrderBy($column = 'position', $sort = 'ASC');
}