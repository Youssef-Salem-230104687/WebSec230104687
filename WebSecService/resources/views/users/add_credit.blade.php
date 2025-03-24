@extends('layouts.master')

@section('title', 'Add Credit')

@section('content')
<div class="container">
    <h1>Add Credit to {{ $user->name }}</h1>

    <form action="{{ route('users_add_credit', $user->id) }}" method="post">
        @csrf
        <div class="mb-3">
            <label for="credit" class="form-label">Credit Amount</label>
            <input type="number" class="form-control" name="credit" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Credit</button>
    </form>
</div>
@endsection