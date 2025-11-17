<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Unit;

class UnitFactory extends Factory
{
    protected $model = Unit::class;

    public function definition()
    {
        return [
            'block' => $this->faker->randomLetter,
            'unit_no' => $this->faker->unique()->numberBetween(1,500),
            'unit_type' => $this->faker->randomElement(['Daire','Dükkan','Ofis']),
            'floor' => $this->faker->numberBetween(0,10),
            'area_m2' => $this->faker->randomFloat(2, 20, 300),
        ];
    }
}
