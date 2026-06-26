<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Models\Student;
use App\Mail\TuitionReminderMail;

class TuitionNotify extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:tuition-notify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send tuition reminder emails to students whose due date is today or earlier';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = now()->toDateString();

        $students = Student::whereDate('due_date', '<=', $today)->get();

        if ($students->isEmpty()) {
            $this->info("No students found with due dates up to {$today}.");
            return;
        }

        foreach ($students as $student) {
            // Use send() instead of queue() for immediate delivery in dev
            Mail::to($student->email)->send(new TuitionReminderMail($student));

            $this->info("Reminder sent to {$student->email}");
        }
    }
}
