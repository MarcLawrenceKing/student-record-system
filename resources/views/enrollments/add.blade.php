@extends('layout')

@section('content')
<div class="container d-flex flex-column justify-content-center align-items-center pt-5 mb-5 px-2">
  <h1 class="pb-3 text-center">Add Enrollment</h1>

  <div class="w-100 d-flex justify-content-end mb-3">
    <a href="/enrollments/batch-create" class="btn btn-primary w-100 w-sm-auto mb-2 mb-sm-0">
        Batch Upload
    </a>
  </div>

  <form action="{{ route('enrollments.store') }}" method="POST" class="w-100">
    @csrf

    <div class="row g-3">
        <!-- Student -->
        <div class="col-12 col-md-6">
            <div class="form-floating">
                <select class="form-select" id="studentId" name="student_id" required>
                    <option value="" disabled {{ old('student_id') === null ? 'selected' : '' }}>Select Student</option>
                    @foreach (\App\Models\Student::orderBy('student_id')->get() as $student)
                        <option value="{{ $student->id }}" 
                            {{ old('student_id') == $student->id ? 'selected' : '' }}>
                            {{ $student->student_id }} - {{ $student->full_name }}
                        </option>
                    @endforeach
                </select>
                <label for="studentId">Student</label>
                @error('student_id')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Subject Code -->
        <div class="col-12 col-md-6">
            <div class="form-floating">
                <select class="form-select" id="subjectCode" name="subject_code" required>
                    <option value="" disabled {{ old('subject_code') === null ? 'selected' : '' }}>Select Subject</option>
                    @foreach (\App\Models\Subject::orderBy('subject_code')->get() as $subject)
                        <option value="{{ $subject->subject_code }}" 
                            {{ old('subject_code') == $subject->subject_code ? 'selected' : '' }}>
                            {{ $subject->subject_code }} - {{ $subject->subject_name }}
                        </option>
                    @endforeach
                </select>
                <label for="subjectCode">Subject</label>
                @error('subject_code')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Year / Semester -->
        <div class="col-12 col-md-6">
            <div class="form-floating">
                <select class="form-select" id="yearSem" name="year_sem" required>
                    <option value="" disabled {{ old('year_sem') === null ? 'selected' : '' }}>Select Year / Semester</option>

                    @php
                        $currentYear = \Carbon\Carbon::now()->year;
                        $years = [$currentYear - 1, $currentYear, $currentYear + 1];
                        $semesters = [1, 2];
                    @endphp

                    @foreach ($years as $year)
                        @foreach ($semesters as $sem)
                            @php
                                $optionValue = $year . '-' . $sem;
                            @endphp
                            <option value="{{ $optionValue }}" {{ old('year_sem') == $optionValue ? 'selected' : '' }}>
                                {{ $optionValue }}
                            </option>
                        @endforeach
                    @endforeach
                </select>
                <label for="yearSem">Year / Semester</label>
                @error('year_sem')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Grade (optional) -->
        <div class="col-12 col-md-6">
            <div class="form-floating">
                <input type="text" class="form-control" id="grade" name="grade" value="{{ old('grade') }}">
                <label for="grade">Grade (optional)</label>
                @error('grade')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <div class="d-flex flex-column flex-sm-row gap-3 mt-3 justify-content-end">
      <a href="{{ route('enrollments.index') }}" class="btn btn-outline-secondary">Cancel</a>
      <button type="submit" class="btn btn-success">Save</button>
    </div>

  </form>
</div>
@endsection
