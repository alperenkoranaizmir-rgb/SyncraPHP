<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Decision;

class DecisionFactory extends Factory
{
    protected $model = Decision::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence(6),
            'description' => $this->faker->paragraph,
            'status' => 'açık',
        ];
    }
}
