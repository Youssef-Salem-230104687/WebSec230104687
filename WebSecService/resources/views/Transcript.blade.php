@extends('layouts.master')
@section('title', 'Student Transcript')
@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header bg-success text-white">
            <h4>Student Transcript</h4>
        </div>
        <div class="card-body">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Course</th>
                        <th>Grade</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transcript as $course)
                    <tr>
                        <td>{{ $course->course }}</td>
                        <td>{{ $course->grade }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection