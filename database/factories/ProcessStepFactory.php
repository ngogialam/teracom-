<?php

namespace Database\Factories;

use App\Models\ProcessStep;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProcessStep>
 */
class ProcessStepFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProcessStep::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'process_id' => rand(1, 7),
            'name' => $this->faker->name,
            'action_type' => rand(0, 3),
            'step_type'  => rand(0, 3),
            'step_order' => rand(0, 1),
            'child_process_id' => rand(1, 7),
            'sla_quantity' => rand(0, 7),
            'sla_unit' => rand(0, 7),
            'transfer_condition_type' => rand(1, 2),
            'created_by' => $this->faker->numerify("##########"),
            'created_at' => Carbon::now()->timestamp,
            'updated_at' => Carbon::now()->timestamp,
            'updated_by' => $this->faker->numerify("##########"),
            'status'  => rand(0, 2),
            'deleted_at' => null,
            'timesheet' => 1
        ];
    }
}
