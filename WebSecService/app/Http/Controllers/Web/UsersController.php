<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Web\Controller;
use App\Models\User;
use DB;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    use ValidatesRequests;

    public function __construct()
    {
        $this->middleware('auth')->except(['login', 'doLogin', 'register', 'doRegister']);
    }
    
    public function list(Request $request)
    {
        // Add check for auth user
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $query = User::query();

        // Only show users list if user has permission or is admin
        if (auth()->user()->hasRole('admin') || auth()->user()->can('show_users')) {
            $users = $query->with('roles')->get();
        } else {
            // User can only see their own profile
            $users = $query->where('id', auth()->id())->with('roles')->get();
        }

        return view("users.list", compact('users'));
    }

    public function edit(Request $request, User $user = null)
    {
        // Only admin can edit other users, or users can edit their own profile
        if (Auth::user()->role === 'admin' || (Auth::id() === $user?->id)) {
            $user = $user ?? new User(); // Create a new User instance if no user is provided
            $roles = Role::all(); // Get all roles

            return view("users.edit", compact('user', 'roles'));
        }

        return redirect()->route('users_list')->with('error', 'You do not have permission to edit this user.');
    }

    public function save(Request $request, User $user = null)
    {
        $this->validate($request, [
            'email' => ['required', 'string', 'max:32'],
            'name' => ['required', 'string', 'max:128'],
            'password' => ['required', 'string', 'max:256'],
            'role' => ['required', 'string', 'in:user,admin'], // Ensure role is either 'user' or 'admin'
        ]);

        // Only admin can save other users, or users can save their own profile
        if (Auth::user()->role === 'admin' || Auth::id() === $user->id) {
            $user = $user ?? new User();
            $user->fill($request->all());
            $user->password = bcrypt($request->password); // Hash the password
            $user->save();
            $user->syncRoles($request->role); // Sync roles

            return redirect()->route('users_list')->with('success', 'User saved successfully.');
        }
        return redirect()->route('users_list')->with('error', 'You do not have permission to save this user.');
    }

    public function delete(Request $request, User $user)
    {
    // Only admin can delete users
    if (Auth::user()->role === 'admin') {
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
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        $user->assignRole('customer'); // Automatically assign "Customer" role

        Auth::login($user);

        return redirect()->route('home')->with('success', 'Registration successful!');
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

    public function profile(Request $request, User $user = null)
    {
        $user = $user ?? auth()->user();

        if (auth()->id() != $user->id && !auth()->user()->hasPermissionTo('show_users')) {
            abort(401, 'Unauthorized');
        }

        $permissions = [];
        foreach($user->permissions as $permission) {
            $permissions[] = $permission;
        }
        foreach($user->roles as $role) {
            foreach($role->permissions as $permission) {
                $permissions[] = $permission;
            }
        }

        return view('users.profile', compact('user', 'permissions'));
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

    public function purchases()
    {
        $user = auth()->user();
        $purchases = $user->purchases()->with('product')->get();

        return view('users.purchases', compact('purchases'));
    }

    public function customers()
    {
        $customers = User::role('customer')->get();
        return view('users.customers', compact('customers'));
    }

    public function addCredit(Request $request, User $user)
    {
        $this->validate($request, [
            'credit' => ['required', 'numeric', 'min:0'],
        ]);

        $user->credit += $request->credit;
        $user->save();

        return redirect()->route('users_customers')->with('success', 'Credit added successfully.');
    }

}