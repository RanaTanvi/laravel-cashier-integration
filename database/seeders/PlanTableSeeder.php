<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class PlanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('plans')->insert([
            [
                'name' => 'Basic',
                'amount' => 20,
                'stripe_plan_id' => 'price_1MlcDTLdWwDLvxaW4jvzqJtD',
            ],
            [
                'name' => 'Premium',
                'amount' => 40,
                'stripe_plan_id' => 'price_1MlcDuLdWwDLvxaW04pI7rLN',
            ],
        ]);
    }
}
