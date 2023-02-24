<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TicketRequest>
 */
class TicketRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            //
            'name' => Str::random(10),
            'department_id' => rand(1, 5),
            'process_id' => rand(1, 10),
            'ticket_serial' => Str::random(40),
            'request_time' => Carbon::now()->timestamp,
            'finish_time' => Carbon::now()->timestamp,
            'priority' => rand(1, 3),
            'comment' => Str::random(40),
            'ticket_action' => rand(1, 2),
            'approval_status' => rand(0, 3),
            'created_by' => $this->faker->numerify("##########"),
            'created_at' => Carbon::now()->timestamp,
            'updated_at' => Carbon::now()->timestamp,
            'updated_by' => $this->faker->numerify("##########"),
            'deleted_at' => null
        ];
    }
}
