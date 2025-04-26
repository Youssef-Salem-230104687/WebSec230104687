<!-- resources/views/emails/verification_code.blade.php -->
@extends('layouts.master')

@section('content')
    <h1>Your Verification Code</h1>
    <p>Your verification code is: <strong>{{ $code }}</strong></p>
    <p>This code will expire in 30 minutes.</p>
@endsection