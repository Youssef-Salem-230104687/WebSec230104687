<?php
// filepath: c:\xampp\htdocs\youssef\WebSec230104687\WebSecService\app\Http\Controllers\Auth\ForgotPasswordController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Web\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\Web\UsersController;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordController extends Controller
{
    public function sendResetLinkEmail(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'security_answer' => 'required|string',
    ]);

    // Find the user
    $user = User::where('email', $request->email)->first();

    if (!$user) {
        return back()->withErrors(['email' => 'User not found.']);
    }

    // Verify the security answer
    if (!Hash::check($request->security_answer, $user->security_answer)) {
        return back()->withErrors(['security_answer' => 'Incorrect security answer.']);
    }

    // Send the password reset link
    $status = Password::sendResetLink($request->only('email'));

    return $status === Password::RESET_LINK_SENT
                ? back()->with(['status' => __($status)])
                : back()->withErrors(['email' => __($status)]);
}
}
?>