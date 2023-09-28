<?php

namespace App\Api\V1\Repositories\Order;
use App\Admin\Repositories\EloquentRepositoryInterface;

interface OrderRepositoryInterface extends EloquentRepositoryInterface
{
	public function createWithDetail(array $data, array $detail);
	public function findOrFailWithRelations($id, array $relations = []);
	public function getByKeyAuthCurrent($filter);
	public function cancel($id);
}