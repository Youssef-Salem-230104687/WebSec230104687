@extends('layouts.master')

@section('title', ($permission ? 'Edit' : 'Create') . ' Permission')

@section('content')
<div class="container">
<div class="container">
    <h1>{{ $permission ? 'Edit' : 'Create' }} Permission</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('permissions_save', $permission?->id) }}" method="POST">
        @csrf
        @method($permission ? 'PUT' : 'POST')

        <div class="mb-3">
            <label for="name" class="form-label">Permission Name</label>
            <input type="text" class="form-control" id="name" name="name" 
                   value="{{ old('name', $permission?->name) }}" required>
        </div>

        <div class="mb-3">
            <label for="display_name" class="form-label">Display Name</label>
            <input type="text" class="form-control" id="display_name" name="display_name" 
                   value="{{ old('display_name', $permission?->display_name) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Save Permission</button>
        <a href="{{ route('permissions_list') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection 