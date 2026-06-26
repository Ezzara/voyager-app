<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        \App\Models\Student::create([
            'name' => 'Alice',
            'email' => 'alice.parent@example.com',
            'due_date' => now()->addDays(3)->toDateString(),
        ]);

        \App\Models\Student::create([
            'name' => 'Bob',
            'email' => 'bob.parent@example.com',
            'due_date' => now()->addDays(1)->toDateString(),
        ]);
        \App\Models\Student::create([
            'name' => 'charlie',
            'email' => 'charlie.parent@example.com',
            'due_date' => now()->toDateString(),
        ]);
    }

}
