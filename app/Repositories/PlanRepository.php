<?php

namespace App\Repositories;

interface PlanRepository {

    public function getPlans();
    public function getPlanById(int $id);
    public function getPlanByStripId(string $stripePlanId);
}