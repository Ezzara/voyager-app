@extends('layouts.app')

@section('content')
<h1>Students</h1>

<!-- Add Student Form -->
<form action="{{ route('students.store') }}" method="POST">
    @csrf
    <input type="text" name="name" placeholder="Name">
    <input type="text" name="parent" placeholder="Parent">
    <input type="email" name="email" placeholder="Email">
    <input type="date" name="due_date">
    <button type="submit">Add Student</button>
</form>

<!-- CSV Upload -->
<form action="{{ route('students.import') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="csv_file" accept=".csv">
    <button type="submit">Upload CSV</button>
</form>

<!-- Student Table -->
<table border="1">
    <tr>
        <th>ID</th><th>Name</th><th>Parent</th><th>Email</th><th>Due Date</th><th>Actions</th>
    </tr>
    @foreach($students as $student)
    <tr>
        <form action="{{ route('students.update', $student->id) }}" method="POST">
            @csrf @method('PUT')
            <td>{{ $student->id }}</td>
            <td><input type="text" name="name" value="{{ $student->name }}"></td>
            <td><input type="text" name="parent" value="{{ $student->parent }}"></td>
            <td><input type="email" name="email" value="{{ $student->email }}"></td>
            <td><input type="date" name="due_date" value="{{ $student->due_date }}"></td>
            <td>
                <button type="submit">Edit</button>
        </form>
        <form action="{{ route('students.destroy', $student->id) }}" method="POST" style="display:inline;">
            @csrf @method('DELETE')
            <button type="submit">Delete</button>
        </form>
            </td>
    </tr>
    @endforeach
</table>
@endsection
