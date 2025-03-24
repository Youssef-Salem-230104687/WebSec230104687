@extends('layouts.master')
@section('title', 'Profile Page')
@section('content')
<div class="container">
    <h1>Profile</h1>

    <div class="form-group">
    @foreach($errors->all() as $error)
    <div class="alert alert-danger">
      <strong> Error!</strong>{{$error}}
    </div>
    @endforeach
  </div>

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">User Information</h5>
            <p class="card-text"><strong>Name:</strong> {{ $user->name }}</p>
            <p class="card-text"><strong>Email:</strong> {{ $user->email }}</p>
            <p class="card-text"><strong>Credit:</strong> ${{ $user->credit }}</p>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Change Password</h5>
            <form action="{{ route('profile.update_password') }}" method="post">
            @csrf
            <div class="form-group mb-2">
                <label for="current_password">Current Password:</label>
                <input type="password" class="form-control" name="current_password" required>
            </div>
            <div class="form-group mb-2">
                <label for="new_password">New Password:</label>
                <input type="password" class="form-control" name="new_password" required>
            </div>
            <div class="form-group mb-2">
                <label for="new_password_confirmation">Confirm New Password:</label>
                <input type="password" class="form-control" name="new_password_confirmation" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Password</button>
            </form>
        </div>
    </div>
</div>
@endsection