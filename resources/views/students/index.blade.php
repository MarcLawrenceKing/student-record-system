@extends('layout')

@section('content')
<div class="container d-flex flex-column justify-content-center align-items-center pt-5 px-2">
  <h1 class="pb-3 text-center">Student Record System</h1>

  @if($students->isEmpty())
  <!-- Show this if $variable is empty (null, false, "", [], etc.) -->
  <div class="alert alert-info w-100 text-center" role="alert">
    No student yet. Click Add Student to create one!
    <div class="w-100 mt-3">
      <a class="btn btn-primary" href="/students/create"><i class="bi bi-person-plus-fill"></i> Add Student</a>
    </div>
  </div>
  @else
  <!-- Show this if $variable has a value -->
  <!-- search -->
  <div class="w-100 d-flex flex-column flex-md-row justify-content-between mb-3 gap-2">
    <form action="{{ url()->secure(route('students.index')) }}" method="GET" role="search" class="d-flex w-100 ">
      <div class="input-group">
        <input
          type="text"
          name="search"
          class="form-control rounded-start-pill shadow-sm"
          placeholder="Search students..."
          value="{{ request('search') }}"
          aria-label="Search students"
        >
        <button class="btn btn-secondary rounded-end-pill shadow-sm w-25" type="submit">
          <i class="bi bi-search"></i>
        </button>
      </div>
    </form>
    <div class="d-flex flex-column flex-sm-row gap-2 w-100 w-sm-auto">
      <a class="btn btn-primary w-100 w-sm-auto" href="/students/create"><i class="bi bi-person-plus-fill"></i> Add Student</a>
      <form id="bulkDeleteForm" action="{{ route('students.bulkDelete') }}" method="POST" class="w-100 w-sm-auto">
        @csrf
        @method('DELETE')

        <button type="submit" data-confirm="delete" id="deleteSelectedBtn" class="btn btn-danger w-100 w-sm-auto" disabled>
          <i class="bi bi-trash"></i> Delete Selected
        </button>
      </form>
    </div>
  </div>

  <div class="table-responsive w-100">
    <table class="table table-striped table-hover align-middle text-nowrap">
      <thead>
        <tr>
          <th>
            <input type="checkbox" id="selectAll" class="form-check-input form-check-input-lg">
          </th>
          <th scope="col">
            <a href="{{ route('students.index', ['sort' => 'student_id', 'direction' => ($sortField === 'student_id' && $sortDirection === 'asc') ? 'desc' : 'asc', 'search' => request('search')]) }}" class>
              ID {!! $sortField === 'student_id' ? ($sortDirection === 'asc' ? '&#9650;' : '&#9660;') : '' !!}
            </a>
          </th>
          <th scope="col">
            <a href="{{ route('students.index', ['sort' => 'full_name', 'direction' => ($sortField === 'full_name' && $sortDirection === 'asc') ? 'desc' : 'asc', 'search' => request('search')]) }}">
            Fullname {!! $sortField === 'full_name' ? ($sortDirection === 'asc' ? '&#9650;' : '&#9660;') : '' !!}
          </a>
          </th>
          <th scope="col">
            <a href="{{ route('students.index', ['sort' => 'email', 'direction' => ($sortField === 'email' && $sortDirection === 'asc') ? 'desc' : 'asc', 'search' => request('search')]) }}">
              Email {!! $sortField === 'email' ? ($sortDirection === 'asc' ? '&#9650;' : '&#9660;') : '' !!}
            </a>
          </th>
          <th scope="col">
            <a href="{{ route('students.index', ['sort' => 'course_program', 'direction' => ($sortField === 'course_program' && $sortDirection === 'asc') ? 'desc' : 'asc', 'search' => request('search')]) }}">
              Course {!! $sortField === 'course_program' ? ($sortDirection === 'asc' ? '&#9650;' : '&#9660;') : '' !!}
            </a> 
          </th>
          <th scope="col">
            <a href="{{ route('students.index', ['sort' => 'year_level', 'direction' => ($sortField === 'year_level' && $sortDirection === 'asc') ? 'desc' : 'asc', 'search' => request('search')]) }}">
              Year & Level {!! $sortField === 'year_level' ? ($sortDirection === 'asc' ? '&#9650;' : '&#9660;') : '' !!}
            </a>
          </th>
        </tr>
      </thead>
      <tbody>
        @foreach($students as $student)
        <tr class="student-row" data-id="{{ $student->id }}">
          <td>
            <input type="checkbox" class="student-checkbox form-check-input form-check-input-lg" name="ids[]" value="{{ $student->id }}" form="bulkDeleteForm">
          </td>
          <th scope="row">{{ $student->student_id }}</th>
          <td>{{ $student->full_name }}</td>
          <td>{{ $student->email }}</td>
          <td>{{ $student->course_program }}</td>
          <td>{{ $student->year_level }}</td>
        </tr>
        @endforeach

      </tbody>
    </table>
  </div>
  @endif

  <div class="d-flex justify-content-center w-100 overflow-auto">
    {{ $students->links() }}
  </div>

</div>

<script>
  // script to view a student and select checkbox to delete
  document.addEventListener('DOMContentLoaded', function () {

    const checkboxes = document.querySelectorAll('.student-checkbox');
    const selectAll = document.getElementById('selectAll');
    const deleteBtn = document.getElementById('deleteSelectedBtn');

    // Row click redirect (VIEW)
    document.querySelectorAll('.student-row').forEach(row => {
      row.addEventListener('click', function (e) {
        if (e.target.matches('.student-checkbox')) return; // ignore checkbox clicks
        let studentId = this.dataset.id;
        window.location.href = `/students/${studentId}`;
      });
    });

    // Select All checkbox
    selectAll.addEventListener('change', function () {
      checkboxes.forEach(cb => cb.checked = selectAll.checked);
      updateDeleteButton();
    });

    // Update when individual checkboxes change
    checkboxes.forEach(cb => {
      cb.addEventListener('change', updateDeleteButton);
    });

    function updateDeleteButton() {
      const anyChecked = [...checkboxes].some(cb => cb.checked);
      deleteBtn.disabled = !anyChecked;
    }

  });
</script>
@endsection