<?php

namespace App\Http\Controllers;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller {
    public function index() {
        $students = Student::all();
        return view('students.index', compact('students'));
    }

    public function store(Request $request) {
        Student::create($request->all());
        return redirect()->route('students.index')->with('success', 'Student added!');
    }

    public function update(Request $request, Student $student) {
        $student->update($request->all());
        return redirect()->route('students.index')->with('success', 'Student updated!');
    }

    public function destroy(Student $student) {
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Student deleted!');
    }

    public function import(Request $request) {
        $file = $request->file('csv_file');
        if (($handle = fopen($file->getRealPath(), 'r')) !== false) {
            while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                Student::create([
                    'name' => $data[0],
                    'parent' => $data[1],
                    'email' => $data[2],
                    'due_date' => $data[3],
                ]);
            }
            fclose($handle);
        }
        return redirect()->route('students.index')->with('success', 'CSV imported!');
    }
}
