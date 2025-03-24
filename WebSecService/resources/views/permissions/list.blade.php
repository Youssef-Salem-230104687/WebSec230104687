
@extends('layouts.master')

@section('title', 'Permissions Management')

@section('content')
<div class="container">
    <h1>Permissions Management</h1>
    
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('permissions_edit') }}" class="btn btn-success mb-3">Create New Permission</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Display Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($permissions as $permission)
                <tr>
                    <td>{{ $permission->name }}</td>
                    <td>{{ $permission->display_name }}</td>
                    <td>
                        <a href="{{ route('permissions_edit', $permission) }}" class="btn btn-primary btn-sm">Edit</a>
                        <form action="{{ route('permissions_delete', $permission) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" 
                                    onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection