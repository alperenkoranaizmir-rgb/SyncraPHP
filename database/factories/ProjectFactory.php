<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Project;

class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition()
    {
        return [
            'name' => $this->faker->company.' Projesi',
            'type' => 'Kentsel Dönüşüm',
            'start_date' => now()->subMonths(rand(1,12)),
            'est_end_date' => now()->addMonths(rand(6,36)),
        ];
    }
}
