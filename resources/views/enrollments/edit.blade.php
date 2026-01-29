@extends('layout')

@section('content')
<div class="container d-flex flex-column justify-content-center align-items-center pt-5 mb-5 px-2">
    <h1 class="pb-3 text-center">Edit Student</h1>

  <form action="{{ route('students.update', $student) }}" method="POST" class="w-100 w-md-75 w-lg-50"  enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <!-- Student Image (full width) -->
    <div class="col-12 mb-3">
        <label for="image" class="form-label w-100 text-center text-muted">Student Image (optional)</label>
        @if($student->image ?? false)
            <div class="mb-2 text-center">
                <img src="{{ Storage::disk('s3')->temporaryUrl($student->image, now()->addMinutes(5)) }}" 
                     alt="Current Image" class="img-fluid img-thumbnail" width="100">
            </div>
        @endif
        <input type="file" name="image" class="form-control" accept="image/*">
        @error('image')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
    </div>

    <div class="row g-3">
        <!-- Student ID -->
        <div class="col-12 col-md-6">
            <div class="form-floating">
                <input type="text" class="form-control" id="studentId" name="student_id"
                    value="{{ old('student_id', $student->student_id) }}" required>
                <label for="studentId">Student ID</label>
                @error('student_id')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Full Name -->
        <div class="col-12 col-md-6">
            <div class="form-floating">
                <input type="text" class="form-control" id="fullName" name="full_name"
                    value="{{ old('full_name', $student->full_name) }}" required>
                <label for="fullName">Full Name</label>
                @error('full_name')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Date of Birth -->
        <div class="col-12 col-md-6">
            <div class="form-floating">
                <input type="date" class="form-control" id="dateOfBirth" name="date_of_birth"
                    value="{{ old('date_of_birth', $student->date_of_birth) }}" required>
                <label for="dateOfBirth">Date of Birth</label>
                @error('date_of_birth')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Gender -->
        <div class="col-12 col-md-6">
            <div class="form-floating">
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
        </div>

        <!-- Email -->
        <div class="col-12 col-md-6">
            <div class="form-floating">
                <input type="email" class="form-control" id="email" name="email"
                    value="{{ old('email', $student->email) }}" required>
                <label for="email">Email</label>
                @error('email')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Course / Program -->
        <div class="col-12 col-md-6">
            <div class="form-floating">
                <input type="text" class="form-control" id="courseProgram" name="course_program"
                    value="{{ old('course_program', $student->course_program) }}" required>
                <label for="courseProgram">Course / Program</label>
                @error('course_program')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Year Level -->
        <div class="col-12 col-md-6">
            <div class="form-floating">
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
        </div>
    </div>

    <div class="d-flex flex-column flex-sm-row gap-3 mt-4 justify-content-end">
      <a href="{{ route('students.index') }}" class="btn btn-outline-secondary mt-0">Cancel</a>
      <button type="submit" data-confirm="update" class="btn btn-success">Save</button>
    </div>
  </form>

</div>

@endsection