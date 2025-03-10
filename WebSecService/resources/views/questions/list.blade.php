@extends('layouts.master')

@section('title', 'Questions List')

@section('content')
<div class="container">
    <h1>Questions List</h1>
    <a href="{{ route('questions_edit') }}" class="btn btn-success mb-3">Add Question</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Question</th>
                <th>Options</th>
                <th>Correct Answer</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($questions as $question)
                <tr>
                    <td>{{ $question->id }}</td>
                    <td>{{ $question->question }}</td>
                    <td>
                        A: {{ $question->option_a }}<br>
                        B: {{ $question->option_b }}<br>
                        C: {{ $question->option_c }}<br>
                        D: {{ $question->option_d }}
                    </td>
                    <td>{{ $question->correct_answer }}</td>
                    <td>
                        <a href="{{ route('questions_edit', $question->id) }}" class="btn btn-primary">Edit</a>
                        <a href="{{ route('questions_delete', $question->id) }}" class="btn btn-danger">Delete</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection