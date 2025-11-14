@extends('layout')

@section('content')
<div class="container d-flex flex-column justify-content-center align-items-center pt-5 mb-5">
    <h1 class="mb-4">Student Details</h1>

    <div class="w-50 space-y-2">

        <!-- Student ID -->
        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="studentId"
                   value="{{ $student->student_id }}" readonly>
            <label for="studentId">Student ID</label>
        </div>

        <!-- Full Name -->
        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="fullName"
                   value="{{ $student->full_name }}" readonly>
            <label for="fullName">Full Name</label>
        </div>

        <!-- Date of Birth -->
        <div class="form-floating mb-3">
            <input type="date" class="form-control" id="dateOfBirth"
                   value="{{ $student->date_of_birth }}" readonly>
            <label for="dateOfBirth">Date of Birth</label>
        </div>

        <!-- Gender -->
        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="gender"
                   value="{{ $student->gender }}" readonly>
            <label for="gender">Gender</label>
        </div>

        <!-- Email -->
        <div class="form-floating mb-3">
            <input type="email" class="form-control" id="email"
                   value="{{ $student->email }}" readonly>
            <label for="email">Email</label>
        </div>

        <!-- Course / Program -->
        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="courseProgram"
                   value="{{ $student->course_program }}" readonly>
            <label for="courseProgram">Course / Program</label>
        </div>

        <!-- Year Level -->
        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="yearLevel"
                   value="{{ $student->year_level }}" readonly>
            <label for="yearLevel">Year Level</label>
        </div>

        <div class="d-flex gap-2 mt-3 justify-content-end">
            <a href="{{ route('students.index') }}" class="btn btn-outline-secondary">Back</a>
            <a href="{{ route('students.edit', $student) }}" class="btn btn-outline-primary">Edit</a>
        </div>

    </div>

</div>
@endsection
