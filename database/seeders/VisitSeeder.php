<?php

namespace Database\Seeders;

use App\Models\Visit;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class VisitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Visit::truncate();

        $visits = include base_path('data/visits.php');

        foreach ($visits as $visitData) {
            $visit = new Visit();
            $visit->apartment_id = $visitData['apartment_id'];
            $visit->visitor_ip = $visitData['visitor_ip'];

            // Genera una data casuale compresa tra il 10 e il 18 marzo 2024 con orario
            $createdAt = Carbon::createFromFormat('Y-m-d H:i:s', '2024-03-10 00:00:00')
                ->addSeconds(rand(0, 691199)) // 691199 secondi sono esattamente 7 giorni meno un secondo
                ->format('Y-m-d H:i:s');

            $visit->created_at = $createdAt;
            $visit->save();
        }
    }
}
