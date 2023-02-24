<?php

namespace Database\Seeders;

use App\Models\Process;
use App\Models\ProcessChangeLog;
use Illuminate\Database\Seeder;

class ProcessChangeLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $processIds = Process::select('id')->get()->toArray();
        foreach ($processIds as $processId) {
            ProcessChangeLog::factory()->create([
                'process_id' => $processId['id'],
                'change_type' => 0,
            ]);
        }
    }
}
