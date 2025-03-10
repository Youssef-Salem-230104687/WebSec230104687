@extends('layouts.master')

@section('title', 'Edit Grade')

@section('content')
<div class="container">
    <h1>{{ $grade->id ? 'Edit' : 'Add' }} Grade</h1>
    <form action="{{ route('grades_save', $grade->id) }}" method="post">
        @csrf
        <div class="mb-3">
            <label for="student_id" class="form-label">Student ID</label>
            <input type="number" class="form-control" name="student_id" value="{{ $grade->student_id }}" required>
        </div>
        <div class="mb-3">
            <label for="course_id" class="form-label">Course ID</label>
            <input type="number" class="form-control" name="course_id" value="{{ $grade->course_id }}" required>
        </div>
        <div class="mb-3">
            <label for="grade" class="form-label">Grade</label>
            <input type="text" class="form-control" name="grade" value="{{ $grade->grade }}" required>
        </div>
        <div class="mb-3">
            <label for="term" class="form-label">Term</label>
            <input type="text" class="form-control" name="term" value="{{ $grade->term }}" required>
        </div>
        <div class="mb-3">
            <label for="credit_hours" class="form-label">Credit Hours</label>
            <input type="number" class="form-control" name="credit_hours" value="{{ $grade->credit_hours }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>
@endsection