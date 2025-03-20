@extends('layouts.master')
@section('content')
<div class="container">
    <h1>Forgot Password</h1>
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <button type="submit" class="btn btn-primary">Send Password Reset Link</button>
    </form>
</div>
@endsection

?>