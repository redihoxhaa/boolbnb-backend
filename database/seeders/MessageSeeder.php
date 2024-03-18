<?php

namespace Database\Seeders;

use App\Models\Message;
use Carbon\Carbon;
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
        Message::truncate();

        $messages = include base_path('data/messages.php');

        foreach ($messages as $messageData) {
            $message = new Message();
            $message->sender_name = $messageData['sender_name'];
            $message->sender_email = $messageData['sender_email'];
            $message->message_text = $messageData['message_text'];

            // Genera una data casuale compresa tra il 10 e il 18 marzo 2024 con orario
            $createdAt = Carbon::createFromFormat('Y-m-d H:i:s', '2024-03-10 00:00:00')
                ->addSeconds(rand(0, 691199)) // 691199 secondi sono esattamente 7 giorni meno un secondo
                ->format('Y-m-d H:i:s');

            $message->created_at = $createdAt;
            $message->save();
        }
    }
}
