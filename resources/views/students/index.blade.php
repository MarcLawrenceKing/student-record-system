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
  <table class="table text-center align-middle">
    <thead>
      <tr>
        <th scope="col">ID</th>
        <th scope="col">Fullname</th>
        <th scope="col">Email</th>
        <th scope="col">Year & Level</th>
        <th scope="col">Course</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody>
      @foreach($students as $student)
      <tr>
        <th scope="row">{{ $student->student_id }}</th>
        <td>{{ $student->full_name }}</td>
        <td>{{ $student->email }}</td>
        <td>{{ $student->year_level }}</td>
        <td>{{ $student->course_program }}</td>
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

</div>


@endsection