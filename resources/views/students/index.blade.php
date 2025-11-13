@extends('layout')

@section('content')
<div class="container d-flex flex-column justify-content-center align-items-center pt-5 ">
  <h1 class="pb-3">List of Students</h1>

  @if($students->isEmpty())
  <!-- Show this if $variable is empty (null, false, "", [], etc.) -->
  <div class="alert alert-info" role="alert">
    No student yet. Click Add Student to create one!
  </div>
  @else
  <!-- Show this if $variable has a value -->
  <!-- search -->
  <div class="w-100 d-flex justify-content-start mb-3">
    <form action="{{ route('students.index') }}" method="GET" role="search" class="d-flex w-100">
      <input
        type="text"
        name="search"
        class="form-control me-2"
        placeholder="Search students..."
        value="{{ request('search') }}"
      >
      <button class="btn btn-outline-primary" type="submit">Search</button>
    </form>
  </div>

  <table class="table text-start align-center">
    <thead>
      <tr>
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
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody>
      @foreach($students as $student)
      <tr class="student-row" data-id="{{ $student->id }}">
        <th scope="row">{{ $student->student_id }}</th>
        <td>{{ $student->full_name }}</td>
        <td>{{ $student->email }}</td>
        <td>{{ $student->course_program }}</td>
        <td>{{ $student->year_level }}</td>
        <td>
          <a class="btn btn-primary" href="{{ route('students.edit', $student) }}"><i class="bi bi-pencil-square"></i>
          </a>
          <form action="{{ route('students.destroy', $student) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger" type="submit"><i class="bi bi-trash"></i>
            </button>
          </form>
        </td>
      </tr>
      @endforeach

    </tbody>
  </table>
  @endif

  <div class="d-flex justify-content-center">
    {{ $students->links() }}
  </div>

  @include('students.modals.view')

</div>


@endsection


<script>
document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.student-row').forEach(row => {
    row.addEventListener('click', function (e) {
      // Ignore clicks on the Action buttons
      if (e.target.closest('a') || e.target.closest('form') || e.target.closest('button')) return;

      const studentId = this.dataset.id;

      fetch(`/students/${studentId}`)
        .then(response => response.json())
        .then(student => {
          document.getElementById('view_student_id').textContent = student.student_id;
          document.getElementById('view_full_name').textContent = student.full_name;
          document.getElementById('view_date_of_birth').textContent = student.date_of_birth;
          document.getElementById('view_gender').textContent = student.gender;
          document.getElementById('view_email').textContent = student.email;
          document.getElementById('view_course_program').textContent = student.course_program;
          document.getElementById('view_year_level').textContent = student.year_level;

          const modal = new bootstrap.Modal(document.getElementById('viewStudentModal'));
          modal.show();
        });
    });
  });
});
</script>