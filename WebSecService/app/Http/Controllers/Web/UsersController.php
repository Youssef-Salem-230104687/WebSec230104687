<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use DB;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    use ValidatesRequests;
    // List all users (with optional filtering)
    public function list(Request $request)
    {
        // Start the query
        $query = User::query();

        // Filter by name
        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }

        // Filter by email
        if ($request->has('email')) {
            $query->where('email', 'like', '%' . $request->input('email') . '%');
        }

        // Filter by role
        if ($request->has('role')) {
            $query->where('role', $request->input('role'));
        }

        // Check if the authenticated user is an admin
        if (Auth::user()->admin) 
        {
            // Admin can view all users
            $users = $query->get();
        } 

        else 
        {
            // Non-admin users can only view their own profile
            $users = $query->where('id', Auth::id())->get();
        }

        // Get the filtered users
        $users = $query->get();

        // Pass the filters to the view
        $filters = $request->only(['name', 'email', 'role']);

        return view("users.list", compact('users', 'filters'));
    }

    // Show the form to create/edit a user
    public function edit(Request $request, User $user = null)
    {
        // Only admin can edit other users
        if (Auth::user()->admin || Auth::id() === $user->id) {
            $user = $user ?? new User();
            return view("users.edit", compact('user'));
        }
        return redirect()->route('home')->with('error', 'You do not have permission to edit this user.');
    }

    // Save a user (create or update)
    public function save(Request $request, User $user = null)
    {

        $this->validate($request, [
            'email' => ['required', 'string', 'max:32'],
            'name' => ['required', 'string', 'max:128'],
            'password' => ['required', 'string', 'max:256'],
            'role' => ['required', 'string', 'max:1024'],
        ]);

        // Only admin can save other users
        if (Auth::user()->admin || Auth::id() === $user->id) {
            $user = $user ?? new User();
            $user->fill($request->all());
            $user->save();
            return redirect()->route('users_list');
        }
        return redirect()->route('home')->with('error', 'You do not have permission to save this user.');
    }

    // Delete a user
    public function delete(Request $request, User $user)
    {
        // Only admin can delete users
        if (Auth::user()->admin) {
            $user->delete();
            return redirect()->route('users_list');
        }
        return redirect()->route('home')->with('error', 'You do not have permission to delete this user.');
    }

    public function register(Request $request) 
    {
        return view('users.register');
    }
    
    public function doRegister(Request $request) 
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'min:5'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'confirmed', Password::min(5)->numbers()->letters()->mixedCase()->symbols()],
            'role' => ['required', 'in:user,admin'], // Validate the role field
        ]);


            $user =  new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->role = $request->role; // Save the selected role
            $user->save();

            if($request->password!=$request->password_confirmation)
                    return redirect()->route('register', ['error'=>'Confirm password not matched.']);

            if(!$request->email || !$request->name || !$request->password)
                    return redirect()->route('register', ['error'=>'Missing input registration info.']);

            if(User::where('email', $request->email)->first())
                    return redirect()->route('register', ['error'=>'Missing registration info.']);

                    
        return redirect('/');
    }
    
    public function login(Request $request) 
    {
        return view('users.login');
    }
    
    public function doLogin(Request $request) 
    {

        if (!Auth::attempt(['email'=> $request->email, 'password'=> $request->password]))
        return redirect()->back()->withInput($request->input())->withErrors('Invalid login information.');
        
         $user = User::where('email', $request->email)->first();
         Auth::setUser($user);
        return redirect('/')->with('success' , 'Login Successful!');
    }
    
    public function doLogout(Request $request) 
    {
        Auth::logout();
        return redirect('/');
    }

    public function profile()
    {
        // Get the authenticated user
        $user = Auth::user();
        return view('users.profile', compact('user'));
    }
   
  
    public function updatePassword(Request $request)
{
    // Validate the request
    $request->validate([
        'current_password' => ['required', 'string'],
        'new_password' => ['required', 'string', 'confirmed', Password::min(5)->numbers()->letters()->mixedCase()->symbols()],
    ]);

    // Get the authenticated user
    $user = Auth::user();

    // Check if the current password is correct
    if (!Hash::check($request->current_password, $user->password)) {
        return redirect()->back()->withErrors(['current_password' => 'The current password is incorrect.']);
    }

    // Update the password
    $user->update([
        'password' => Hash::make($request->new_password) // Hash the new password
    ]);     

    // Redirect back with a success message
    return redirect()->back()->with('success', 'Password updated successfully!');
}

}   