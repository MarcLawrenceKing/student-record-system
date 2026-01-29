@extends('layout')

@section('content')
<div class="container d-flex flex-column justify-content-center align-items-center pt-5 mb-5 px-2">
    <h1 class="pb-3 text-center">Edit Enrollment</h1>

    <form action="{{ route('enrollments.update', $enrollment) }}" method="POST" class="w-100 w-md-75 w-lg-50">
        @csrf
        @method('PUT')

        <div class="row g-3">

            <!-- Student Info (read-only) -->
            <div class="col-12 mb-3">
                <label for="studentName" class="form-label w-100 text-center text-muted">Student</label>
                <div class="text-center mb-2">
                    @if($enrollment->student && $enrollment->student->image)
                        <img src="{{ Storage::disk('s3')->temporaryUrl($enrollment->student->image, now()->addMinutes(5)) }}" 
                             alt="Student Image" class="img-fluid img-thumbnail" width="100">
                    @endif
                </div>
                <input type="text" class="form-control text-center" id="studentName"
                       value="{{ $enrollment->student->full_name ?? 'N/A' }}" readonly>
            </div>

            <!-- Subject Code -->
            <div class="col-12 col-md-6">
                <div class="form-floating">
                    <input type="text" class="form-control" id="subjectCode" name="subject_code"
                        value="{{ old('subject_code', $enrollment->subject_code) }}" required>
                    <label for="subjectCode">Subject Code</label>
                    @error('subject_code')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Year / Semester -->
            <div class="col-12 col-md-6">
                <div class="form-floating">
                    <input type="text" class="form-control" id="yearSem" name="year_sem"
                        value="{{ old('year_sem', $enrollment->year_sem) }}" required>
                    <label for="yearSem">Year / Semester</label>
                    @error('year_sem')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Grade -->
            <div class="col-12 col-md-6">
                <div class="form-floating">
                    <input type="text" class="form-control" id="grade" name="grade"
                        value="{{ old('grade', $enrollment->grade) }}">
                    <label for="grade">Grade</label>
                    @error('grade')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
            </div>

        </div>

        <div class="d-flex flex-column flex-sm-row gap-3 mt-4 justify-content-end">
            <a href="{{ route('enrollments.index') }}" class="btn btn-outline-secondary mt-0">Cancel</a>
            <button type="submit" class="btn btn-success">Save</button>
        </div>

    </form>

</div>
@endsection
