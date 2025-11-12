@extends('layout')

@section('content')
<div class="container d-flex flex-column justify-content-center align-items-center pt-5">
  <h1 class="pb-3">Edit Student</h1>

  <form action="{{ route('students.update', $student) }}" method="POST" class="w-50 space-y-2">
    @csrf
    @method('PUT')

    <!-- Student ID -->
    <div class="form-floating mb-3">
        <input type="text" class="form-control" id="studentId" name="student_id"
               value="{{ old('student_id', $student->student_id) }}" required>
        <label for="studentId">Student ID</label>
        @error('student_id')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
    </div>

    <!-- Full Name -->
    <div class="form-floating mb-3">
        <input type="text" class="form-control" id="fullName" name="full_name"
               value="{{ old('full_name', $student->full_name) }}" required>
        <label for="fullName">Full Name</label>
        @error('full_name')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
    </div>

    <!-- Date of Birth -->
    <div class="form-floating mb-3">
        <input type="date" class="form-control" id="dateOfBirth" name="date_of_birth"
               value="{{ old('date_of_birth', $student->date_of_birth) }}" required>
        <label for="dateOfBirth">Date of Birth</label>
        @error('date_of_birth')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
    </div>

    <!-- Gender -->
    <div class="form-floating mb-3">
        <select class="form-select" id="gender" name="gender" required>
            <option value="Male" {{ old('gender', $student->gender) == 'Male' ? 'selected' : '' }}>Male</option>
            <option value="Female" {{ old('gender', $student->gender) == 'Female' ? 'selected' : '' }}>Female</option>
            <option value="Other" {{ old('gender', $student->gender) == 'Other' ? 'selected' : '' }}>Other</option>
        </select>
        <label for="gender">Gender</label>
        @error('gender')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
    </div>

    <!-- Email -->
    <div class="form-floating mb-3">
        <input type="email" class="form-control" id="email" name="email"
               value="{{ old('email', $student->email) }}" required>
        <label for="email">Email</label>
        @error('email')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
    </div>

    <!-- Course / Program -->
    <div class="form-floating mb-3">
        <input type="text" class="form-control" id="courseProgram" name="course_program"
               value="{{ old('course_program', $student->course_program) }}" required>
        <label for="courseProgram">Course / Program</label>
        @error('course_program')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
    </div>

    <!-- Year Level -->
    <div class="form-floating mb-3">
        <select class="form-select" id="yearLevel" name="year_level" required>
            <option value="1st Year" {{ old('year_level', $student->year_level) == '1st Year' ? 'selected' : '' }}>1st Year</option>
            <option value="2nd Year" {{ old('year_level', $student->year_level) == '2nd Year' ? 'selected' : '' }}>2nd Year</option>
            <option value="3rd Year" {{ old('year_level', $student->year_level) == '3rd Year' ? 'selected' : '' }}>3rd Year</option>
            <option value="4th Year" {{ old('year_level', $student->year_level) == '4th Year' ? 'selected' : '' }}>4th Year</option>
        </select>
        <label for="yearLevel">Year Level</label>
        @error('year_level')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
    </div>

    <div class="d-flex gap-2 mt-2 justify-content-end">
      <a href="{{ route('students.index') }}" class="btn btn-outline-secondary mt-0">Cancel</a>
      <button type="submit" class="btn btn-outline-success">Save</button>
    </div>


  </form>

</div>

@endsection