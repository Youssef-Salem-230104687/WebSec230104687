@extends('layouts.master')

@section('title', 'Edit Question')

@section('content')
<div class="container">
    <h1>{{ $question->id ? 'Edit' : 'Add' }} Question</h1>
    <form action="{{ route('questions_save', $question->id) }}" method="post">
        @csrf
        <div class="mb-3">
            <label for="question" class="form-label">Question</label>
            <input type="text" class="form-control" name="question" value="{{ $question->question }}" required>
        </div>
        <div class="mb-3">
            <label for="option_a" class="form-label">Option A</label>
            <input type="text" class="form-control" name="option_a" value="{{ $question->option_a }}" required>
        </div>
        <div class="mb-3">
            <label for="option_b" class="form-label">Option B</label>
            <input type="text" class="form-control" name="option_b" value="{{ $question->option_b }}" required>
        </div>
        <div class="mb-3">
            <label for="option_c" class="form-label">Option C</label>
            <input type="text" class="form-control" name="option_c" value="{{ $question->option_c }}" required>
        </div>
        <div class="mb-3">
            <label for="option_d" class="form-label">Option D</label>
            <input type="text" class="form-control" name="option_d" value="{{ $question->option_d }}" required>
        </div>
        <div class="mb-3">
            <label for="correct_answer" class="form-label">Correct Answer</label>
            <select class="form-select" name="correct_answer" required>
                <option value="A" {{ $question->correct_answer == 'A' ? 'selected' : '' }}>A</option>
                <option value="B" {{ $question->correct_answer == 'B' ? 'selected' : '' }}>B</option>
                <option value="C" {{ $question->correct_answer == 'C' ? 'selected' : '' }}>C</option>
                <option value="D" {{ $question->correct_answer == 'D' ? 'selected' : '' }}>D</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>
@endsection