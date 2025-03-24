@extends('layouts.master')
@section('title', 'Users List')
@section('content')
<div class="container">
    <h1>Users List</h1>

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('debug'))
        <div class="alert alert-info">
            <pre>{{ print_r(session('debug'), true) }}</pre>
        </div>
    @endif

    <!-- Add User Button (Only for Admin) -->
    @can('add_users')
        <a href="{{ route('users_edit') }}" class="btn btn-success mb-3">Add User</a>
    @endcan

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Roles</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @foreach($user->roles as $role)
                            <span class="badge bg-primary">{{ $role->name }}</span>
                        @endforeach
                    </td>
                    <td>
                        @can('edit_users')
                            <a href="{{ route('users_edit', $user->id) }}" class="btn btn-primary btn-sm">Edit</a>
                        @endcan
                        @can('delete_users')
                            <form action="{{ route('users_delete', $user->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        @endcan
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection