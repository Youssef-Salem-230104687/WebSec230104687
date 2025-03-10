@extends('layouts.master')

@section('title', 'MCQ Exam')

@section('content')
<div class="container">
    <h1>MCQ Exam</h1>
    <form action="{{ route('questions_submit') }}" method="post">
        @csrf
        @foreach($questions as $question)
            <div class="card mb-3">
                <div class="card-body">
                    <h5>{{ $question->question }}</h5>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="answer_{{ $question->id }}" value="A" required>
                        <label class="form-check-label">A: {{ $question->option_a }}</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="answer_{{ $question->id }}" value="B" required>
                        <label class="form-check-label">B: {{ $question->option_b }}</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="answer_{{ $question->id }}" value="C" required>
                        <label class="form-check-label">C: {{ $question->option_c }}</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="answer_{{ $question->id }}" value="D" required>
                        <label class="form-check-label">D: {{ $question->option_d }}</label>
                    </div>
                </div>
            </div>
        @endforeach
        <button type="submit" class="btn btn-primary">Submit Exam</button>
    </form>
</div>
@endsection