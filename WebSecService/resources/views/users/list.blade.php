@extends('layouts.master')
@section('title', 'Users List')
@section('content')
<div class="container">
    <h1>Users List</h1>

    <!-- Add User Button (Only for users with edit_users permission) -->
    @can('edit_users')
        <a href="{{ route('users_edit') }}" class="btn btn-success mb-3">Add User</a>
    @endcan

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
                    @foreach(Spatie\Permission\Models\Role::all() as $role)
                        <option value="{{ $role->name }}" {{ isset($filters['role']) && $filters['role'] == $role->name ? 'selected' : '' }}>
                            {{ ucfirst($role->name) }}
                        </option>
                    @endforeach
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
                    <th>Roles</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @foreach($user->roles as $role)
                                <span class="badge bg-primary">{{ $role->name }}</span>
                            @endforeach
                        </td>
                        <td>
                            <!-- Edit Button (Visible to users with edit_users permission or the User Themselves) -->
                            @if(auth()->user()->can('edit_users') || auth()->id() === $user->id)
                                <a href="{{ route('users_edit', $user->id) }}" class="btn btn-primary btn-sm">Edit</a>
                            @endif

                            <!-- Delete Button (Only for users with delete_users permission) -->
                            @can('delete_users')
                                <a href="{{ route('users_delete', $user->id) }}" class="btn btn-danger btn-sm">Delete</a>
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endcan
</div>
@endsection