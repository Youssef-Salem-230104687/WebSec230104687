<?php
    use Illuminate\Http\Request;

    class VerificationController extends Controller {
        public function resend(Request $request)
        {
            if ($request->user()->hasVerifiedEmail()) {
                return redirect()->route('home')->with('message', 'Your email is already verified.');
            }
        
            $request->user()->sendEmailVerificationNotification();
        
            return back()->with('message', 'Verification email sent!');
        }
    }
?>