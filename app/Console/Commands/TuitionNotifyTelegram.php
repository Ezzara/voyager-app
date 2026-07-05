<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Student;

class TuitionNotifyTelegram extends Command
{
    protected $signature = 'app:tuition-notify-telegram';
    protected $description = 'Send tuition reminders via Telegram group';

    public function handle()
    {
        $students = Student::where('due_date', '<', now())->get();

        foreach ($students as $student) {
            try {
                $token   = env('TELEGRAM_BOT_TOKEN');
                $chatId  = env('TELEGRAM_GROUPCHAT_ID'); // group chat ID from secrets
                $url     = "https://api.telegram.org/bot{$token}/sendMessage";

                // ✅ Fix: due_date must be cast to datetime in Student model
                // app/Models/Student.php -> protected $casts = ['due_date' => 'datetime'];
                $dueDate = $student->due_date instanceof \Carbon\Carbon
                    ? $student->due_date->format('Y-m-d')
                    : $student->due_date; // fallback if still string

                Http::post($url, [
                    'chat_id' => $chatId,
                    'text'    => "Reminder: {$student->name}, your tuition is overdue since {$dueDate}."
                ]);

                $this->info("Telegram sent for {$student->name}");
            } catch (\Exception $e) {
                $this->error("Telegram failed for {$student->name}: " . $e->getMessage());
            }
        }
    }
}
