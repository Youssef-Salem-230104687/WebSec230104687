@extends('layouts.master')
@section('content')
    <h1>Verify Your Email Address</h1>
    <p>Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.</p>

    @if (session('status') == 'verification-link-sent')
        <div>
            A new verification link has been sent to the email address you provided during registration.
        </div>
    @endif

    <form method="POST" action="{{ route('verification.resend') }}">
        @csrf
        <button type="submit">Resend Verification Email</button>
    </form>

    <form method="POST" action="{{ route('do_logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>
@endsection
