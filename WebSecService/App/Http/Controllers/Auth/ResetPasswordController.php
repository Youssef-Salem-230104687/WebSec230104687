<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Web\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ResetPasswordController extends Controller
{
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->save();

                Auth::login($user);
            }
        );

        return $status === Password::PASSWORD_RESET
                    ? redirect()->route('home')->with('status', __($status))
                    : back()->withErrors(['email' => [__($status)]]);
    }
}
?>