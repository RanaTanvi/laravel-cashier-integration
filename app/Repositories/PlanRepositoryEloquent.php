<?php

namespace App\Repositories;

use App\Models\Plan;
use Illuminate\Support\Facades\DB;


class PlanRepositoryEloquent implements PlanRepository
{

	private $model;
	private $adminAddressRepository;

	public function __construct(Plan $model)
	{
		$this->model = $model;
	}

	/** get all plans */
	public function getPlans() {
		return $this->model->get();
	}

	/** get plan by id */
	public function getPlanById($id) {
		return $this->model->where('id', $id)->first();
	}
	
	/** get plan by id */
	public function getPlanByStripId($stripePlaneId) {
		return $this->model->where('stripe_plan_id', $stripePlaneId)->first();
	}
}
