<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Models\Student;
use App\Mail\TuitionReminderMail;

class TuitionNotifyGmailTest extends Command
{
    protected $signature = 'app:tuition-notify-gmail-test';
    protected $description = 'Send tuition reminders via Gmail SMTP (test mailer)';

    public function handle()
    {
        $students = Student::where('due_date', '<', now())->get();

        foreach ($students as $student) {
            try {
                Mail::mailer('test')
                    ->to($student->email)
                    ->send(new TuitionReminderMail($student));

                $this->info("Gmail test mail sent to {$student->name}");
            } catch (\Exception $e) {
                $this->error("Gmail test failed for {$student->name}: " . $e->getMessage());
            }
        }
    }
}
