<?php
// filepath: c:\xampp\htdocs\youssef\WebSec230104687\WebSecService\app\Http\Controllers\Auth\ForgotPasswordController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Web\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
                    ? back()->with(['status' => __($status)])
                    : back()->withErrors(['email' => __($status)]);
    }
}
?>