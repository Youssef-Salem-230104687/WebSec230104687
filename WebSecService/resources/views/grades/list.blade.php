@extends('layouts.master')

@section('title', 'Grades List')

@section('content')
<div class="container">
    <h1>Grades List</h1>
    <a href="{{ route('grades_edit') }}" class="btn btn-success mb-3">Add Grade</a>

    @if($grades->isEmpty())
        <p>No grades found.</p>
    @else
        @foreach($grades as $term => $termGrades)
            <h2>Term: {{ $term }}</h2>
            @if($termGrades->isEmpty())
                <p>No grades found for this term.</p>
            @else
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Student ID</th>
                            <th>Course ID</th>
                            <th>Grade</th>
                            <th>Credit Hours</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($termGrades as $grade)
                            <tr>
                                <td>{{ $grade->id }}</td>
                                <td>{{ $grade->student_id }}</td>
                                <td>{{ $grade->course_id }}</td>
                                <td>{{ $grade->grade }}</td>
                                <td>{{ $grade->credit_hours }}</td>
                                <td>
                                    @can('edit_grades')
                                    <a href="{{ route('grades_edit', $grade->id) }}" class="btn btn-primary">Edit</a>
                                    @endcan
                                    <form action="{{ route('grades_delete', $grade->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <p><strong>Term GPA:</strong> {{ number_format($termGPAs[$term], 2) }}</p>
            @endif
        @endforeach

        <p><strong>Cumulative CGPA:</strong> {{ number_format($cumulative['cgpa'], 2) }}</p>
        <p><strong>Cumulative Credit Hours:</strong> {{ $cumulative['cch'] }}</p>
    @endif
</div>
@endsection