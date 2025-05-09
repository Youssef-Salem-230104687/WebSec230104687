@extends('layouts.master')
@section('title', 'Register Page')
@section('content')
<form action="{{route('do_register')}}" method="post">
  {{ csrf_field() }}
  
  <div class="form-group">
    @if(request()->error)
      <div class="alert alert-danger">
        <strong> Error! </strong> {{request()->error}}
      </div>
    @endif

  <div class="form-group">
    @foreach($errors->all() as $error)
    <div  class="alert alert-danger">
      <strong> Error!</strong>{{$error}}
    </div>
    @endforeach
  </div>

  <div class="form-group mb-2">
    <label for="code" class="form-label">Name:</label>
    <input type="text" class="form-control" placeholder="name" name="name" required>
  </div>

  <div class="form-group mb-2">
    <label for="model" class="form-label">Email:</label>
    <input type="email" class="form-control" placeholder="email" name="email" required>
  </div>

  <div class="form-group mb-2">
    <label for="model" class="form-label">Password:</label>
    <input type="password" class="form-control" placeholder="password" name="password" required>
  </div>

  <div class="form-group mb-2">
    <label for="model" class="form-label">Password Confirmation:</label>
    <input type="password" class="form-control" placeholder="Confirmation" name="password_confirmation" required>
  </div>


  <div class="form-group mb-2">
    <label for="role" class="form-label">Role:</label>
    <select class="form-control" name="role" required>
      <option value="user">User</option>
      <option value="admin">Admin</option>
    </select>
  </div> 

  <div class="form-group mb-2">
    <button type="submit" class="btn btn-primary">Register</button>
  </div>
  
</form>

@endsection