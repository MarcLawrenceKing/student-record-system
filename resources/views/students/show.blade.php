@extends('layout')

@section('content')
<div class="container d-flex flex-column justify-content-center align-items-center pt-5 mb-5 px-2">
    <h1 class="mb-4 text-center">Student Details</h1>

    <div class="w-100 w-md-75 w-lg-50">

        <!-- Student Image -->   
        <div class="mb-4 text-center">
            @if($student->image)
                <img src="{{ Storage::disk('s3')->temporaryUrl($student->image, now()->addMinutes(5)) }}" alt="Student Image" width="100" class="img-fluid img-thumbnail" style="max-width: 150px;">            
            @else
                <span class="text-muted">No image available</span>
            @endif
        </div>
        
        <div class="row g-3">
        <!-- Student ID -->
            <div class="col-12 col-md-6">
                <div class="form-floating">
                    <input type="text" class="form-control" id="studentId"
                        value="{{ $student->student_id }}" readonly>
                    <label for="studentId">Student ID</label>
                </div>
            </div>

            <!-- Full Name -->
            <div class="col-12 col-md-6">
                <div class="form-floating">
                    <input type="text" class="form-control" id="fullName"
                        value="{{ $student->full_name }}" readonly>
                    <label for="fullName">Full Name</label>
                </div>
            </div>

            <!-- Date of Birth -->
            <div class="col-12 col-md-6">
                <div class="form-floating">
                    <input type="date" class="form-control" id="dateOfBirth"
                        value="{{ $student->date_of_birth }}" readonly>
                    <label for="dateOfBirth">Date of Birth</label>
                </div>
            </div>

            <!-- Gender -->
            <div class="col-12 col-md-6">
                <div class="form-floating">
                    <input type="text" class="form-control" id="gender"
                        value="{{ $student->gender }}" readonly>
                    <label for="gender">Gender</label>
                </div>
            </div>

            <!-- Email -->
            <div class="col-12 col-md-6">
                <div class="form-floating">
                    <input type="email" class="form-control" id="email"
                        value="{{ $student->email }}" readonly>
                    <label for="email">Email</label>
                </div>
            </div>

            <!-- Course / Program -->
            <div class="col-12 col-md-6">
                <div class="form-floating">
                    <input type="text" class="form-control" id="courseProgram"
                        value="{{ $student->course_program }}" readonly>
                    <label for="courseProgram">Course / Program</label>
                </div>
            </div>

            <!-- Year Level -->
            <div class="col-12 col-md-6">
                <div class="form-floating">
                    <input type="text" class="form-control" id="yearLevel"
                        value="{{ $student->year_level }}" readonly>
                    <label for="yearLevel">Year Level</label>
                </div>
            </div>
        </div>



        <div class="d-flex flex-column flex-sm-row gap-3 mt-4 justify-content-end">
            <a href="{{ route('students.index') }}" class="btn btn-outline-secondary">Back</a>
            <a href="{{ route('students.edit', $student) }}" class="btn btn-primary">Edit</a>
        </div>

    </div>

</div>
@endsection
