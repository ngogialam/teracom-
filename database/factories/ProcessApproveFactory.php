<?php

namespace Database\Factories;

use App\Models\ApprovalProcessLog;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ApprovalProcessLog>
 */
class ProcessApproveFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = ApprovalProcessLog::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition()
    {
        return [
            'process_id' => rand(1, 7),
            'approval_status' => rand(0, 4),
            'comment'  => $this->faker->text,
            'created_by' => $this->faker->numerify("##########"),
            'created_at' => Carbon::now()->timestamp,
            'updated_at' => Carbon::now()->timestamp,
            'updated_by' => $this->faker->numerify("##########"),
        ];
    }
}
