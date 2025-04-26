@extends('layouts.master')
@section('title', 'Mobile Verification')
@section('content')
    <h1>Enter Verification Code</h1>
    <form action="{{ route('mobile.verification.submit') }}" method="POST">
        @csrf
        <label for="code">Verification Code:</label>
        <input type="text" name="code" id="code" required>
        <button type="submit">Submit</button>
    </form>

    <form action="{{ route('mobile.verification.resend') }}" method="POST">
        @csrf
        <button type="submit">Resend Code</button>
    </form>
@endsection