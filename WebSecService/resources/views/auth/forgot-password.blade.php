@extends('layouts.master')
@section('content')
<div class="container">
    <h1>Forgot Password</h1>
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="form-group">

            <label for="email">Email address</label>
            <input type="email" class="form-control" id="email" name="email" required>

        </div>

        <button type="submit" class="btn btn-primary">Send Password Reset Link</button>

        <div class="form-group">

          <label for="security_question">Security Question</label>
          <input type="text" class="form-control" id="security_question" name="security_question" readonly>

        </div>

        <div class="form-group">

           <label for="security_answer">Security Answer</label>
           <input type="text" class="form-control" id="security_answer" name="security_answer" required>
           
        </div>
    </form>

    <script>
        document.getElementById('email').addEventListener('blur', function() {
            const email = this.value;
            if (email) {
                fetch(`/get-security-question?email=${email}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.security_question) {
                            document.getElementById('security_question').value = data.security_question;
                        } else {
                            document.getElementById('security_question').value = 'No security question found for this email.';
                        }
                    })
                    .catch(error => console.error('Error fetching security question:', error));
            }
        });
    </script>
</div>
@endsection

