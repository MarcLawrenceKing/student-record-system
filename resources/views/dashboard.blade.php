@extends('layout')

@section('content')
<div class="container py-5">

  <h1 class="text-center mb-5">Student Record System - 1/30/26 Updates</h1>

  <div class="card mb-4 shadow-sm">
    <div class="card-header bg-primary text-white">
      <strong>Goals / Requirements</strong>
    </div>
    <div class="card-body">
      <ul>
        <li>Manage exactly <strong>5 subjects per student</strong>.</li>
        <li>Compute <strong>average grades</strong> automatically.</li>
        <li>Send a <strong>summary email</strong> once all 5 subjects have grades.</li>
      </ul>
    </div>
  </div>

  <div class="card mb-4 shadow-sm">
    <div class="card-header bg-success text-white">
      <strong>Tasks Completed</strong>
    </div>
    <div class="card-body">

      <h5 class="mb-3">1. Database Tables</h5>
      <p>Created 3 new tables to meet the requirements:</p>

      <h6 class="mt-3 mb-3"> ** SUBJECTS **</h6>
      <table class="table table-bordered table-striped">
        <thead class="">
          <tr>
            <th>Name</th>
            <th>Data Type</th>
            <th>Description</th>
          </tr>
        </thead>
        <tbody>
          <tr><td>id</td><td>bigint, auto-increment</td><td>Primary key</td></tr>
          <tr><td>subject_code</td><td>varchar(20)</td><td>Unique code for the subject</td></tr>
          <tr><td>subject_name</td><td>varchar(100)</td><td>Name of the subject</td></tr>
          <tr><td>created_at</td><td>timestamp</td><td>Record creation time</td></tr>
          <tr><td>updated_at</td><td>timestamp</td><td>Record last update time</td></tr>
        </tbody>
      </table>

      <h6 class="mt-3 mb-3"> ** ENROLLMENTS **</h6>
      <table class="table table-bordered table-striped">
        <thead class="">
          <tr>
            <th>Name</th>
            <th>Data Type</th>
            <th>Description</th>
          </tr>
        </thead>
        <tbody>
          <tr><td>id</td><td>bigint, auto-increment</td><td>Primary key</td></tr>
          <tr><td>student_id</td><td>bigint, FK</td><td>References <code>students.id</code></td></tr>
          <tr><td>subject_code</td><td>varchar(20)</td><td>Code of the enrolled subject</td></tr>
          <tr><td>year_sem</td><td>varchar(20)</td><td>Year & semester of enrollment</td></tr>
          <tr><td>grade</td><td>decimal(5,2)</td><td>Grade for the subject (nullable)</td></tr>
          <tr><td>created_at</td><td>timestamp</td><td>Record creation time</td></tr>
          <tr><td>updated_at</td><td>timestamp</td><td>Record last update time</td></tr>
        </tbody>
      </table>

      <h6 class="mt-3 mb-3"> ** SUMMARY_EMAIL (grades_email) **</h6>
      <table class="table table-bordered table-striped">
        <thead class="">
          <tr>
            <th>Name</th>
            <th>Data Type</th>
            <th>Description</th>
          </tr>
        </thead>
        <tbody>
          <tr><td>id</td><td>bigint, auto-increment</td><td>Primary key</td></tr>
          <tr><td>student_id</td><td>bigint, FK</td><td>References <code>students.id</code></td></tr>
          <tr><td>year_sem</td><td>varchar(20)</td><td>Year & semester</td></tr>
          <tr><td>subject_count</td><td>tinyint</td><td>Total subjects enrolled</td></tr>
          <tr><td>subject_with_grades</td><td>tinyint</td><td>Subjects with grades assigned</td></tr>
          <tr><td>average_grades</td><td>decimal(5,2)</td><td>Average of all grades (nullable)</td></tr>
          <tr><td>sent</td><td>boolean</td><td>Whether summary email has been sent</td></tr>
          <tr><td>created_at</td><td>timestamp</td><td>Record creation time</td></tr>
          <tr><td>updated_at</td><td>timestamp</td><td>Record last update time</td></tr>
        </tbody>
      </table>

      <h5 class="mb-2 mt-4">2. Subjects</h5>
      <ul>
        <li>No CRUD for subjects and grades_email (not required by the project goals).</li>
      </ul>

      <h5 class="mb-2 mt-4">3. Enrollments</h5>
      <ul>
        <li>Full CRUD available (create, read, edit, delete).</li>
        <li>Batch upload feature for multiple enrollments via CSV template.</li>
        <li>Validation prevents duplicate enrollments for the same student, subject, and semester.</li>
      </ul>

      <h5 class="mb-2 mt-4">4. Summary Email</h5>
      <ul>
        <li>Records are derived from <code>enrollments</code>.</li>
        <li>Emails can be sent only if a student has <strong>5 subjects with grades</strong>.</li>
        <li>Validation prevents sending emails for students with insufficient grades.</li>
        <li>Mailtrap used for testing (requires proper .env configuration).</li>
      </ul>

    </div>
  </div>

</div>
@endsection
