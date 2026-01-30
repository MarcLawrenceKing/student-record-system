@extends('layout')

@section('content')
<div class="container d-flex flex-column justify-content-center align-items-center pt-5 px-2">
  <h1 class="pb-3 text-center">Summary Email</h1>

  @if($summary_emails->isEmpty())
    <div class="alert alert-info w-100 text-center" role="alert">
      No Summary Emails yet. Click Add Summary Emails to create one!
      <div class="w-100 mt-3">
        <a class="btn btn-primary" href="/summary_emails/create">
          <i class="bi bi-person-plus-fill"></i> Add summary email
        </a>
      </div>
    </div>
  @else

  <!-- Search + Send -->
  <div class="w-100 d-flex flex-column flex-md-row justify-content-between mb-3 gap-2">
    <form action="{{ route('summary_emails.index') }}" method="GET" role="search" class="d-flex w-100">
      <div class="input-group">
        <input
          type="text"
          name="search"
          class="form-control rounded-start-pill shadow-sm"
          placeholder="Search summary emails..."
          value="{{ request('search') }}"
        >
        <button class="btn btn-secondary rounded-end-pill shadow-sm w-25" type="submit">
          <i class="bi bi-search"></i>
        </button>
      </div>
    </form>

    <button type="submit" form="bulkSendForm" id="sendSelectedBtn"
      class="btn btn-success w-100 w-sm-auto" disabled>
      <i class="bi bi-envelope"></i> Send Email to Selected
    </button>
  </div>

  <!-- BULK SEND FORM -->
  <form id="bulkSendForm" action="{{ route('summary_emails.bulkSend') }}" method="POST" class="w-100">
    @csrf

    <div class="table-responsive w-100">
      <table class="table table-striped table-hover align-middle text-nowrap">
        <thead>
          <tr>
            <th>
              <input type="checkbox" id="selectAll" class="form-check-input form-check-input-lg">
            </th>
            <th>ID</th>
            <th>Student</th>
            <th>Year & Sem</th>
            <th>Subject Count</th>
            <th>With Grades</th>
            <th>Average</th>
            <th>Sent</th>
          </tr>
        </thead>
        <tbody>
          @foreach($summary_emails as $summary_email)
          <tr class="summary_email-row" data-id="{{ $summary_email->id }}">
            <td>
              <input
                type="checkbox"
                class="summary_email-checkbox form-check-input form-check-input-lg"
                name="ids[]"
                value="{{ $summary_email->id }}"
              >
            </td>
            <td>{{ $summary_email->id }}</td>
            <td>
              {{ $summary_email->student->student_id ?? '-' }} –
              {{ $summary_email->student->full_name ?? '-' }}
            </td>
            <td>{{ $summary_email->year_sem }}</td>
            <td>{{ $summary_email->subject_count }}</td>
            <td>{{ $summary_email->subject_with_grades }}</td>
            <td>{{ $summary_email->average_grades }}</td>
            <td>{{ $summary_email->sent ? 'Yes' : 'No' }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </form>

  <div class="d-flex justify-content-center w-100 overflow-auto">
    {{ $summary_emails->links() }}
  </div>

  @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const checkboxes = document.querySelectorAll('.summary_email-checkbox');
  const selectAll = document.getElementById('selectAll');
  const sendBtn = document.getElementById('sendSelectedBtn');

  // // Row click → view page
  // document.querySelectorAll('.summary_email-row').forEach(row => {
  //   row.addEventListener('click', function (e) {
  //     if (e.target.type === 'checkbox') return;
  //     window.location.href = `/summary_emails/${this.dataset.id}`;
  //   });
  // });

  function updateButton() {
    sendBtn.disabled = ![...checkboxes].some(cb => cb.checked);
  }

  selectAll.addEventListener('change', () => {
    checkboxes.forEach(cb => cb.checked = selectAll.checked);
    updateButton();
  });

  checkboxes.forEach(cb => cb.addEventListener('change', updateButton));
});
</script>

@endsection