<?php

namespace Database\Seeders;

use App\Models\Sponsorship;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class SponsorshipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Temporarily disable foreign key checks
        Schema::disableForeignKeyConstraints();

        // Truncate the apartments table
        Sponsorship::truncate();

        // Truncate the pivot table apartment_technology
        DB::table('apartment_sponsorship')->truncate();

        // Re-enable foreign key checks
        Schema::enableForeignKeyConstraints();

        $sponsorships = include base_path('data/sponsorships.php');

        foreach ($sponsorships as $sponsorshipData) {
            Sponsorship::create($sponsorshipData);
        }
    }
}
