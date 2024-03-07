<?php

namespace Database\Seeders;

use App\Models\Apartment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class ApartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Temporarily disable foreign key checks
        Schema::disableForeignKeyConstraints();

        // Truncate the apartments table
        Apartment::truncate();

        // Truncate the pivot table apartment_technology
        DB::table('apartment_service')->truncate();
        DB::table('apartment_sponsorship')->truncate();

        // Re-enable foreign key checks
        Schema::enableForeignKeyConstraints();


        $apartments = include base_path('data/apartments.php');

        foreach ($apartments as $apartmentData) {
            $apartment = new Apartment();
            $apartment->user_id = $apartmentData['user_id'];
            $apartment->title = $apartmentData['title'];
            $apartment->description = $apartmentData['description'];
            $apartment->rooms = $apartmentData['rooms'];
            $apartment->beds = $apartmentData['beds'];
            $apartment->bathrooms = $apartmentData['bathrooms'];
            $apartment->square_meters = $apartmentData['square_meters'];
            $apartment->address = $apartmentData['address'];
            $apartment->lat = $apartmentData['lat'];
            $apartment->lon = $apartmentData['lon'];
            $apartment->images = implode(',', $apartmentData['images']);
            $apartment->save();
            $apartment->slug = Str::slug($apartmentData['title']) . '-' . $apartment->id;
            $apartment->save();
            if (isset($apartmentData['services'])) {
                $apartment->services()->sync($apartmentData['services']);
            } else {
                $apartment->services()->sync([]);
            }
        }
    }
}
