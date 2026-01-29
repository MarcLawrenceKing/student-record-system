@extends('layout')

@section('content')
<div class="container d-flex flex-column justify-content-center align-items-center pt-5 px-2">
  <h1 class="pb-3 text-center">Summary Email</h1>

  @if($summary_emails->isEmpty())
  <!-- Show this if $variable is empty (null, false, "", [], etc.) -->
  <div class="alert alert-info w-100 text-center" role="alert">
    No Summary Emails yet. Click Add Summary Emails to create one!
    <div class="w-100 mt-3">
      <a class="btn btn-primary" href="/summary_emails/create"><i class="bi bi-person-plus-fill"></i> Add summary_email</a>
    </div>
  </div>
  @else
  <!-- Show this if $variable has a value -->
  <!-- search -->
  <div class="w-100 d-flex flex-column flex-md-row justify-content-between mb-3 gap-2">
    <form action="{{ route('summary_emails.index') }}" method="GET" role="search" class="d-flex w-100 ">
      <div class="input-group">
        <input
          type="text"
          name="search"
          class="form-control rounded-start-pill shadow-sm"
          placeholder="Search summary_emails..."
          value="{{ request('search') }}"
          aria-label="Search summary_emails"
        >
        <button class="btn btn-secondary rounded-end-pill shadow-sm w-25" type="submit">
          <i class="bi bi-search"></i>
        </button>
      </div>
    </form>
    <div class="d-flex flex-column flex-sm-row gap-2 w-100 w-sm-auto">
      <a class="btn btn-primary w-100 w-sm-auto" href="/summary_emails/create"><i class="bi bi-person-plus-fill"></i> Add summary_email</a>
      <form id="bulkDeleteForm" action="{{ route('summary_emails.bulkDelete') }}" method="POST" class="w-100 w-sm-auto">
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
            <a href="{{ route('summary_emails.index', ['sort' => 'id', 'direction' => ($sortField === 'id' && $sortDirection === 'asc') ? 'desc' : 'asc', 'search' => request('search')]) }}" class>
              ID {!! $sortField === 'id' ? ($sortDirection === 'asc' ? '&#9650;' : '&#9660;') : '' !!}
            </a>
          </th>
          <th scope="col">
            <a href="{{ route('summary_emails.index', ['sort' => 'student_id', 'direction' => ($sortField === 'student_id' && $sortDirection === 'asc') ? 'desc' : 'asc', 'search' => request('search')]) }}">
            Student ID {!! $sortField === 'student_id' ? ($sortDirection === 'asc' ? '&#9650;' : '&#9660;') : '' !!}
            </a>
          </th>
          <th scope="col">
            <a href="{{ route('summary_emails.index', ['sort' => 'year_sem', 'direction' => ($sortField === 'year_sem' && $sortDirection === 'asc') ? 'desc' : 'asc', 'search' => request('search')]) }}">
            Year & Sem {!! $sortField === 'year_sem' ? ($sortDirection === 'asc' ? '&#9650;' : '&#9660;') : '' !!}
            </a>
          </th>
          <th scope="col">
            <a href="{{ route('summary_emails.index', ['sort' => 'subject_count', 'direction' => ($sortField === 'subject_count' && $sortDirection === 'asc') ? 'desc' : 'asc', 'search' => request('search')]) }}">
            Subject Count {!! $sortField === 'subject_count' ? ($sortDirection === 'asc' ? '&#9650;' : '&#9660;') : '' !!}
            </a>
          </th>
          <th scope="col">
            <a href="{{ route('summary_emails.index', ['sort' => 'subject_with_grades', 'direction' => ($sortField === 'subject_with_grades' && $sortDirection === 'asc') ? 'desc' : 'asc', 'search' => request('search')]) }}">
            Subject With Grades {!! $sortField === 'subject_with_grades' ? ($sortDirection === 'asc' ? '&#9650;' : '&#9660;') : '' !!}
            </a>
          </th>
          <th scope="col">
            <a href="{{ route('summary_emails.index', ['sort' => 'average_grades', 'direction' => ($sortField === 'average_grades' && $sortDirection === 'asc') ? 'desc' : 'asc', 'search' => request('search')]) }}">
            Average Grades {!! $sortField === 'average_grades' ? ($sortDirection === 'asc' ? '&#9650;' : '&#9660;') : '' !!}
            </a>
          </th>
          <th scope="col">
            <a href="{{ route('summary_emails.index', ['sort' => 'sent', 'direction' => ($sortField === 'sent' && $sortDirection === 'asc') ? 'desc' : 'asc', 'search' => request('search')]) }}">
            Sent {!! $sortField === 'sent' ? ($sortDirection === 'asc' ? '&#9650;' : '&#9660;') : '' !!}
            </a>
          </th>
        </tr>
      </thead>
      <tbody>
        @foreach($summary_emails as $summary_email)
        <tr class="summary_email-row" data-id="{{ $summary_email->id }}">
          <td>
            <input type="checkbox" class="summary_email-checkbox form-check-input form-check-input-lg" name="ids[]" value="{{ $summary_email->id }}" form="bulkDeleteForm">
          </td>
          <th scope="row">{{ $summary_email->id }}</th>
          <td>
              {{ $summary_email->student->id ?? '-' }} - {{ $summary_email->student->student_id ?? '-' }} - {{ $summary_email->student->full_name ?? '-' }}
          </td>
          <td>{{ $summary_email->year_sem }}</td>
          <td>{{ $summary_email->subject_count }}</td>
          <td>{{ $summary_email->subject_with_grades }}</td>
          <td>{{ $summary_email->average_grades }}</td>
          <td>{{ $summary_email->sent }}</td>
        </tr>
        @endforeach

      </tbody>
    </table>
  </div>
  @endif

  <div class="d-flex justify-content-center w-100 overflow-auto">
    {{ $summary_emails->links() }}
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
        window.location.href = `/summary_emails/${studentId}`;
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