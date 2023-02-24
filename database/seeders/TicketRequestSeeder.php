<?php

namespace Database\Seeders;

use App\Models\TicketRequest;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TicketRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        return TicketRequest::factory()->count(10)->create();
    }
}
