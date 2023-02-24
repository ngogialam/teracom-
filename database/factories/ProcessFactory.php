<?php

namespace Database\Factories;

use App\Models\Process;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Process>
 */
class ProcessFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Process::class;


    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'code' => $this->faker->numerify("##########"),
            'name' => $this->faker->name,
            'short_name' => $this->faker->firstName,
            'owner_deparment_id' => rand(1, 10),
            'target_apply_type' => rand(1, 2),
            'regulation_document' => $this->faker->text,
            'regulation_start_date' => Carbon::now()->timestamp,
            'regulation_end_date' => Carbon::now()->timestamp,
            'description' => $this->faker->paragraphs(1, true),
            'approval_status' => rand(1, 4),
            'approval_target_type' => rand(1, 2),
            'version' => 1,
            'created_by' => $this->faker->numerify("##########"),
            'created_at' => Carbon::now()->timestamp,
            'updated_at' => Carbon::now()->timestamp,
            'updated_by' => $this->faker->numerify("##########"),
            'status' => rand(0, 1)
        ];
    }
}
