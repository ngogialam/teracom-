<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Task;
use Illuminate\Support\Str;

use function Ramsey\Uuid\v1;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Task::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'ticket_req_id' => rand(1, 10),
            'step_id' => rand(1, 10),
            'task_type' => rand(1, 2),
            'assignee_id' => rand(1, 2),
            'department_id' => rand(1, 2),
            'actual_complete_time' => $this->faker->numerify("#########"),
            'expected_complete_time' => $this->faker->numerify("#########"),
            'action' => rand(1, 2),
            'approval_status' => rand(0, 4),
            'rollback_step_id' => rand(1, 10),
            'rollback_type' => rand(1, 2),
            'comment' => Str::random(46),
            'created_by' => $this->faker->numerify("#########"),
            'created_at' => $this->faker->numerify("#########"),
            'updated_at' => $this->faker->numerify("#########"),
            'updated_by' => $this->faker->numerify("#########"),
            'status' => rand(1, 3),
        ];
    }
}
