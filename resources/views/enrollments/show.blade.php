@extends('layout')

@section('content')
<div class="container d-flex flex-column justify-content-center align-items-center pt-5 mb-5 px-2">
    <h1 class="mb-4 text-center">Enrollment Details</h1>

    <div class="w-100 w-md-75 w-lg-50">

        <!-- Student Info -->
        <h4 class="mb-3">Student Information</h4>
        <div class="mb-4 text-center">
            @if($enrollment->student && $enrollment->student->image)
                <img src="{{ Storage::disk('s3')->temporaryUrl($enrollment->student->image, now()->addMinutes(5)) }}" 
                     alt="Student Image" width="100" class="img-fluid img-thumbnail" style="max-width: 150px;">            
            @else
                <span class="text-muted">No image available</span>
            @endif
        </div>
        
        <div class="row g-3 mb-4">
            <!-- Student ID -->
            <div class="col-12 col-md-6">
                <div class="form-floating">
                    <input type="text" class="form-control" id="studentId"
                        value="{{ $enrollment->student->student_id ?? 'N/A' }}" readonly>
                    <label for="studentId">Student ID</label>
                </div>
            </div>

            <!-- Full Name -->
            <div class="col-12 col-md-6">
                <div class="form-floating">
                    <input type="text" class="form-control" id="fullName"
                        value="{{ $enrollment->student->full_name ?? 'N/A' }}" readonly>
                    <label for="fullName">Full Name</label>
                </div>
            </div>

            <!-- Email -->
            <div class="col-12 col-md-6">
                <div class="form-floating">
                    <input type="email" class="form-control" id="email"
                        value="{{ $enrollment->student->email ?? 'N/A' }}" readonly>
                    <label for="email">Email</label>
                </div>
            </div>

            <!-- Course / Program -->
            <div class="col-12 col-md-6">
                <div class="form-floating">
                    <input type="text" class="form-control" id="courseProgram"
                        value="{{ $enrollment->student->course_program ?? 'N/A' }}" readonly>
                    <label for="courseProgram">Course / Program</label>
                </div>
            </div>

            <!-- Year Level -->
            <div class="col-12 col-md-6">
                <div class="form-floating">
                    <input type="text" class="form-control" id="yearLevel"
                        value="{{ $enrollment->student->year_level ?? 'N/A' }}" readonly>
                    <label for="yearLevel">Year Level</label>
                </div>
            </div>
        </div>

        <!-- Enrollment Info -->
        <h4 class="mb-3">Enrollment Information</h4>
        <div class="row g-3 mb-4">
            <!-- Subject Code -->
            <div class="col-12 col-md-6">
                <div class="form-floating">
                    <input type="text" class="form-control" id="subjectCode"
                        value="{{ $enrollment->subject_code }}" readonly>
                    <label for="subjectCode">Subject Code</label>
                </div>
            </div>

            <!-- Year / Semester -->
            <div class="col-12 col-md-6">
                <div class="form-floating">
                    <input type="text" class="form-control" id="yearSem"
                        value="{{ $enrollment->year_sem }}" readonly>
                    <label for="yearSem">Year / Semester</label>
                </div>
            </div>

            <!-- Grade -->
            <div class="col-12 col-md-6">
                <div class="form-floating">
                    <input type="text" class="form-control" id="grade"
                        value="{{ $enrollment->grade ?? '-' }}" readonly>
                    <label for="grade">Grade</label>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="d-flex flex-column flex-sm-row gap-3 mt-4 justify-content-end">
            <a href="{{ route('enrollments.index') }}" class="btn btn-outline-secondary">Back</a>
            <a href="{{ route('enrollments.edit', $enrollment) }}" class="btn btn-primary">Edit</a>
        </div>

    </div>
</div>
@endsection
