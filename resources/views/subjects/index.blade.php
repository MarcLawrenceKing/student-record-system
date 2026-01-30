@extends('layout')

@section('content')
<div class="container d-flex flex-column justify-content-center align-items-center pt-5 px-2">
  <h1 class="pb-3 text-center">Subjects</h1>

  @if($subjects->isEmpty())
  <!-- Show this if $variable is empty (null, false, "", [], etc.) -->
  <div class="alert alert-info w-100 text-center" role="alert">
    No subjects yet. Click Add subjects to create one!
    <div class="w-100 mt-3">
      <a class="btn btn-primary" href="/subjects/create"><i class="bi bi-person-plus-fill"></i> Add Subject</a>
    </div>
  </div>
  @else
  <!-- Show this if $variable has a value -->
  <!-- search -->
  <div class="w-100 d-flex flex-column flex-md-row justify-content-between mb-3 gap-2">
    <form action="{{ route('subjects.index') }}" method="GET" role="search" class="d-flex w-100 ">
      <div class="input-group">
        <input
          type="text"
          name="search"
          class="form-control rounded-start-pill shadow-sm"
          placeholder="Search subjects..."
          value="{{ request('search') }}"
          aria-label="Search subjects"
        >
        <button class="btn btn-secondary rounded-end-pill shadow-sm w-25" type="submit">
          <i class="bi bi-search"></i>
        </button>
      </div>
    </form>
    <!-- <div class="d-flex flex-column flex-sm-row gap-2 w-100 w-sm-auto">
      <a class="btn btn-primary w-100 w-sm-auto" href="/subjects/create"><i class="bi bi-person-plus-fill"></i> Add Subject</a>
      <form id="bulkDeleteForm" action="{{ route('subjects.bulkDelete') }}" method="POST" class="w-100 w-sm-auto">
        @csrf
        @method('DELETE')

        <button type="submit" data-confirm="delete" id="deleteSelectedBtn" class="btn btn-danger w-100 w-sm-auto" disabled>
          <i class="bi bi-trash"></i> Delete Selected
        </button>
      </form>
    </div> -->
  </div>

  <div class="table-responsive w-100">
    <table class="table table-striped table-hover align-middle text-nowrap">
      <thead>
        <tr>
          <th>
            <input type="checkbox" id="selectAll" class="form-check-input form-check-input-lg">
          </th>
          <th scope="col">
            <a href="{{ route('subjects.index', ['sort' => 'subject_code', 'direction' => ($sortField === 'subject_code' && $sortDirection === 'asc') ? 'desc' : 'asc', 'search' => request('search')]) }}" class>
              ID {!! $sortField === 'subject_code' ? ($sortDirection === 'asc' ? '&#9650;' : '&#9660;') : '' !!}
            </a>
          </th>
          <th scope="col">
            <a href="{{ route('subjects.index', ['sort' => 'subject_name', 'direction' => ($sortField === 'subject_name' && $sortDirection === 'asc') ? 'desc' : 'asc', 'search' => request('search')]) }}">
            Subject Name {!! $sortField === 'subject_name' ? ($sortDirection === 'asc' ? '&#9650;' : '&#9660;') : '' !!}
          </a>
        </tr>
      </thead>
      <tbody>
        @foreach($subjects as $subject)
        <tr class="subject-row" data-id="{{ $subject->id }}">
          <td>
            <input type="checkbox" class="subject-checkbox form-check-input form-check-input-lg" name="ids[]" value="{{ $subject->id }}" form="bulkDeleteForm">
          </td>
          <th scope="row">{{ $subject->subject_code }}</th>
          <td>{{ $subject->subject_name }}</td>
        </tr>
        @endforeach

      </tbody>
    </table>
  </div>
  @endif

  <div class="d-flex justify-content-center w-100 overflow-auto">
    {{ $subjects->links() }}
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
        window.location.href = `/subjects/${studentId}`;
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