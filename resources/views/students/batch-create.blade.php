@extends('layout')

@section('content')
<div class="container pt-4 px-2">

    <h2 class="mb-4 text-center">Batch Upload Students</h2>

    {{-- Download template --}}
    <div class="mb-3 d-flex justify-content-start">
        <a href="{{ asset('templates/student_template.csv') }}" class="btn btn-secondary w-100 w-sm-auto">
            Download CSV Template
        </a>
    </div>

    {{-- Upload Form --}}
    <form action="{{ route('students.batch.store') }}" method="POST" enctype="multipart/form-data" class="border p-4 rounded shadow-sm w-100 w-md-75 w-lg-50 mx-auto mb-4">
        @csrf

        <div class="mb-3">
            <label class="form-label">Upload CSV File</label>
            <input type="file" name="csv_file" class="form-control" required>
            @error('csv_file')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex flex-column flex-sm-row gap-3 mt-4 justify-content-end">
            <a href="{{ route('students.index') }}" class="btn btn-outline-secondary">Back</a>
            <button type="submit" class="btn btn-primary w-sm-auto">Upload</button>
        </div>
        
    </form>

    {{-- Invalid Records --}}
    @if(session('invalidRecords'))
    <div class="mt-5">
        <h4 class="text-danger mb-3 text-center text-md-start">Some records were not imported:</h4>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-danger">
                    <tr>
                        <th>Row Data</th>
                        <th>Errors</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach(session('invalidRecords') as $invalid)
                    <tr>
                        <td>
                            <pre class="mb-0">{{ print_r($invalid['data'], true) }}</pre>
                        </td>
                        <td>
                            <ul class="text-danger mb-0">
                                @foreach($invalid['errors'] as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
    @endif

</div>
@endsection
