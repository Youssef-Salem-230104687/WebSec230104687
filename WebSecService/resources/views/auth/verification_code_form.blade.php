@extends('layouts.master')
@section('title', 'Register Page')
@section('content')
    <h1>Enter Verification Code</h1>
    <form action="{{ route('verification.code.submit') }}" method="POST">
        @csrf
        <label for="code">Verification Code:</label>
        <input type="text" name="code" id="code" required>
        <button type="submit">Submit</button>
    </form>

    <form action="{{ route('verification.resend') }}" method="POST">
        @csrf
        <button type="submit">Resend Code</button>
    </form>
@endsection
