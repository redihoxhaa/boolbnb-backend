<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Temporarily disable foreign key checks
        Schema::disableForeignKeyConstraints();

        // Truncate the apartments table
        Service::truncate();

        // Truncate the pivot table apartment_technology
        DB::table('apartment_service')->truncate();

        // Re-enable foreign key checks
        Schema::enableForeignKeyConstraints();

        $services = include base_path('data/services.php');

        foreach ($services as $serviceData) {
            Service::create($serviceData);
        }
    }
}
