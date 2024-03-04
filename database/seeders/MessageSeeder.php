<?php

namespace Database\Seeders;

use App\Models\Message;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Message::truncate();

        $messages = include base_path('data/messages.php');

        foreach ($messages as $messageData) {
            Message::create($messageData);
        }
    }
}
