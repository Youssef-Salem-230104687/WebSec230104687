@extends('layouts.master')

@section('title', 'Exam Result')

@section('content')
<div class="container">
    <h1>Exam Result</h1>
    <p>Your score: {{ $score }} / {{ count($questions) }}</p>
    <a href="{{ route('questions_exam') }}" class="btn btn-primary">Retake Exam</a>
    <a href="{{ route('questions_list') }}" class="btn btn-secondary">Back to MCQ Page</a>  
</div>
@endsection