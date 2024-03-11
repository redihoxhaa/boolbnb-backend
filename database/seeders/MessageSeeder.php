<?php

namespace Database\Seeders;

use App\Models\Message;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Temporarily disable foreign key checks
        Schema::disableForeignKeyConstraints();

        // Truncate the apartments table
        Message::truncate();

        // Re-enable foreign key checks
        Schema::enableForeignKeyConstraints();


        $messages = include base_path('data/messages.php');

        foreach ($messages as $messageData) {
            Message::create($messageData);
        }
    }
}
