@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Add a New Book</div>
    <div class="card-body">
        <form action="{{ route('books.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="mb-3">
                <label for="author" class="form-label">Author</label>
                <input type="text" class="form-control" id="author" name="author" required>
            </div>
            <div class="mb-3">
                <label for="published_year" class="form-label">Published Year</label>
                <input type="number" class="form-control" id="published_year" name="published_year" required min="1000" max="9999">
            </div>
            <button type="submit" class="btn btn-primary">Add Book</button>
        </form>
    </div>
</div>
@endsection