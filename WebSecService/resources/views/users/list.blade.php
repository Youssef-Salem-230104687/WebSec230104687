@extends('layouts.master')
@section('title', 'Users List')
@section('content')
<div class="container">
    <h1>Users List</h1>

    <!-- Add User Button (Only for Admin) -->
    @if(Auth::user()->role === 'admin')
        <a href="{{ route('users_edit') }}" class="btn btn-success mb-3">Add User</a>
    @endif

    <!-- Filter Form -->
    <form action="{{ route('users_list') }}" method="get" class="mb-4">
        <div class="row">
            <div class="col-md-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" name="name" value="{{ $filters['name'] ?? '' }}" placeholder="Filter by name">
            </div>
            <div class="col-md-3">
                <label for="email" class="form-label">Email</label>
                <input type="text" class="form-control" name="email" value="{{ $filters['email'] ?? '' }}" placeholder="Filter by email">
            </div>
            <div class="col-md-3">
                <label for="role" class="form-label">Role</label>
                <select class="form-select" name="role">
                    <option value="">All Roles</option>
                    <option value="admin" {{ isset($filters['role']) && $filters['role'] == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="user" {{ isset($filters['role']) && $filters['role'] == 'user' ? 'selected' : '' }}>User</option>
                </select>
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('users_list') }}" class="btn btn-secondary ms-2">Reset</a>
            </div>
        </div>
    </form>

    <!-- Users Table -->
    @can('show_users')
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role }}</td>
                    <td>
                        <!-- Edit Button (Visible to Admin or the User Themselves) -->
                        @if(Auth::user()->role === 'admin' || Auth::id() === $user->id)
                            <a href="{{ route('users_edit', $user->id) }}" class="btn btn-primary">Edit</a>
                        @endif

                        <!-- Delete Button (Only for Admin) -->
                        @if(Auth::user()->role === 'admin')
                            <a href="{{ route('users_delete', $user->id) }}" class="btn btn-danger">Delete</a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @endcan
</div>
@endsection