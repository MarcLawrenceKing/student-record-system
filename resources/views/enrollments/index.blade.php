@extends('layout')

@section('content')
<div class="container d-flex flex-column justify-content-center align-items-center pt-5 px-2">
  <h1 class="pb-3 text-center">Enrollments</h1>

  @if($enrollments->isEmpty())
  <!-- Show this if $variable is empty (null, false, "", [], etc.) -->
  <div class="alert alert-info w-100 text-center" role="alert">
    No enrollments yet. Click Add enrollments to create one!
    <div class="w-100 mt-3">
      <a class="btn btn-primary" href="/enrollments/create"><i class="bi bi-person-plus-fill"></i> Add enrollment</a>
    </div>
  </div>
  @else
  <!-- Show this if $variable has a value -->
  <!-- search -->
  <div class="w-100 d-flex flex-column flex-md-row justify-content-between mb-3 gap-2">
    <form action="{{ route('enrollments.index') }}" method="GET" role="search" class="d-flex w-100 ">
      <div class="input-group">
        <input
          type="text"
          name="search"
          class="form-control rounded-start-pill shadow-sm"
          placeholder="Search enrollments..."
          value="{{ request('search') }}"
          aria-label="Search enrollments"
        >
        <button class="btn btn-secondary rounded-end-pill shadow-sm w-25" type="submit">
          <i class="bi bi-search"></i>
        </button>
      </div>
    </form>
    <div class="d-flex flex-column flex-sm-row gap-2 w-100 w-sm-auto">
      <a class="btn btn-primary w-100 w-sm-auto" href="/enrollments/create"><i class="bi bi-plus-circle-fill"></i> Add enrollment</a>
      <form id="bulkDeleteForm" action="{{ route('enrollments.bulkDelete') }}" method="POST" class="w-100 w-sm-auto">
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
            <a href="{{ route('enrollments.index', ['sort' => 'id', 'direction' => ($sortField === 'id' && $sortDirection === 'asc') ? 'desc' : 'asc', 'search' => request('search')]) }}" class>
              ID {!! $sortField === 'id' ? ($sortDirection === 'asc' ? '&#9650;' : '&#9660;') : '' !!}
            </a>
          </th>
          <th scope="col">
            <a href="{{ route('enrollments.index', ['sort' => 'student_id', 'direction' => ($sortField === 'student_id' && $sortDirection === 'asc') ? 'desc' : 'asc', 'search' => request('search')]) }}">
            Student ID {!! $sortField === 'student_id' ? ($sortDirection === 'asc' ? '&#9650;' : '&#9660;') : '' !!}
            </a>
          </th>
          <th scope="col">
            <a href="{{ route('enrollments.index', ['sort' => 'subject_code', 'direction' => ($sortField === 'subject_code' && $sortDirection === 'asc') ? 'desc' : 'asc', 'search' => request('search')]) }}">
            Subject Code {!! $sortField === 'subject_code' ? ($sortDirection === 'asc' ? '&#9650;' : '&#9660;') : '' !!}
            </a>
          </th>
          <th scope="col">
            <a href="{{ route('enrollments.index', ['sort' => 'year_sem', 'direction' => ($sortField === 'year_sem' && $sortDirection === 'asc') ? 'desc' : 'asc', 'search' => request('search')]) }}">
            Year & Sem {!! $sortField === 'year_sem' ? ($sortDirection === 'asc' ? '&#9650;' : '&#9660;') : '' !!}
            </a>
          </th>
          <th scope="col">
            <a href="{{ route('enrollments.index', ['sort' => 'grade', 'direction' => ($sortField === 'grade' && $sortDirection === 'asc') ? 'desc' : 'asc', 'search' => request('search')]) }}">
            Grade {!! $sortField === 'grade' ? ($sortDirection === 'asc' ? '&#9650;' : '&#9660;') : '' !!}
            </a>
          </th>
        </tr>
      </thead>
      <tbody>
        @foreach($enrollments as $enrollment)
        <tr class="enrollment-row" data-id="{{ $enrollment->id }}">
          <td>
            <input type="checkbox" class="enrollment-checkbox form-check-input form-check-input-lg" name="ids[]" value="{{ $enrollment->id }}" form="bulkDeleteForm">
          </td>
          <th scope="row">{{ $enrollment->id }}</th>
          <td>
              {{ $enrollment->student->id ?? '-' }} - {{ $enrollment->student->student_id ?? '-' }} - {{ $enrollment->student->full_name ?? '-' }}
          </td>
          <td>{{ $enrollment->subject_code }}</td>
          <td>{{ $enrollment->year_sem }}</td>
          <td>{{ $enrollment->grade }}</td>
        </tr>
        @endforeach

      </tbody>
    </table>
  </div>
  @endif

  <div class="d-flex justify-content-center w-100 overflow-auto">
    {{ $enrollments->links() }}
  </div>

</div>

<script>
  // script to view a enrollment and select checkbox to delete
  document.addEventListener('DOMContentLoaded', function () {

    const checkboxes = document.querySelectorAll('.enrollment-checkbox');
    const selectAll = document.getElementById('selectAll');
    const deleteBtn = document.getElementById('deleteSelectedBtn');

    // Row click redirect (VIEW)
    document.querySelectorAll('.enrollment-row').forEach(row => {
      row.addEventListener('click', function (e) {
        if (e.target.matches('.enrollment-checkbox')) return; // ignore checkbox clicks
        let enrollmentId = this.dataset.id;
        window.location.href = `/enrollments/${enrollmentId}`;
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