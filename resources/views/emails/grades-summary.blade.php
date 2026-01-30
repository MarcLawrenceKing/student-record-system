<h3>Grades Summary for {{ $student->full_name }}</h3>
<p>Student ID: {{ $student->student_id }}</p>
<p>Year/Sem: {{ $year_sem }}</p>
<p><strong>Average Grade:</strong> {{ $summaryEmail->average_grades }}</p>

<table border="1" cellpadding="5" cellspacing="0">
    <tr>
        <th>Subject Code</th>
        <th>Subject Name</th>
        <th>Grade</th>
    </tr>
    @foreach($enrollments as $enrollment)
    <tr>
        <td>{{ $enrollment->subject_code }}</td>
        <td>{{ $enrollment->subject->subject_name ?? '-' }}</td>
        <td>{{ $enrollment->grade ?? '-' }}</td>
    </tr>
    @endforeach
</table>
