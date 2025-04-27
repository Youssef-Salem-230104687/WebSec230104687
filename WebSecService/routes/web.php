<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\ProductsController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\Web\UsersController;
use App\Http\Controllers\Web\QuestionsController;
use App\Http\Controllers\Web\GradesController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Web\BookController;
use App\Http\Controllers\Web\Controller;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\RolesController;

// Public routes
Route::get('/', function () {
    return view('welcome');
});

// Example routes (can be removed if not needed)
Route::get('/multable', function (Request $request) {
    $j = $request->number;
    $msg = $request->msg;
    return view('multable', compact("j", "msg"));
});

Route::get('/even', function () {
    return view('even');
});

Route::get('/prime', function () {
    return view('prime');
});

Route::get('/MiniTest', function () {
    $bill = (object)[
        'supermarket' => "Carrefour",
        'pos' => "5691374",
        'products' => [
            (object)["name" => "Apples", "quantity" => 1, "unit" => "kg", "price" => 2.5],
            (object)["name" => "Milk", "quantity" => 2, "unit" => "liters", "price" => 1.8],
            (object)["name" => "Bread", "quantity" => 3, "unit" => "pieces", "price" => 1.2]
        ]
    ];
    return view('MiniTest', compact("bill"));
});

Route::get('/Transcript', function () {
    $transcript = [
        (object)["course" => "Mathematics", "grade" => "A"],
        (object)["course" => "Physics", "grade" => "B+"],
        (object)["course" => "Chemistry", "grade" => "A-"],
        (object)["course" => "Biology", "grade" => "B"],
        (object)["course" => "Computer Science", "grade" => "A"]
    ];
    return view('Transcript', compact("transcript"));
});

Route::get('/Products', function () {
    $products = [
        (object)[
            'name' => 'Apple iPhone 14',
            'image' => 'https://via.placeholder.com/200',
            'price' => 999.99,
            'description' => 'The latest iPhone with A15 Bionic chip and Super Retina XDR display.'
        ],
        (object)[
            'name' => 'Samsung Galaxy S22',
            'image' => 'https://via.placeholder.com/200',
            'price' => 899.99,
            'description' => 'A powerful Android smartphone with Dynamic AMOLED 2X display.'
        ],
        (object)[
            'name' => 'Google Pixel 7',
            'image' => 'https://via.placeholder.com/200',
            'price' => 799.99,
            'description' => 'The best of Google with Tensor G2 chip and advanced camera features.'
        ],
        (object)[
            'name' => 'OnePlus 10 Pro',
            'image' => 'https://via.placeholder.com/200',
            'price' => 899.99,
            'description' => 'Flagship killer with Hasselblad camera and Snapdragon 8 Gen 1.'
        ]
    ];
    return view('Products', compact("products"));
});

Route::get('/Calculator', function () {
    $courses = [
        ["code" => "CS101", "title" => "Introduction to Computer Science", "credit_hours" => 3],
        ["code" => "MATH101", "title" => "Calculus I", "credit_hours" => 4],
        ["code" => "PHYS101", "title" => "Physics I", "credit_hours" => 4],
        ["code" => "ENG101", "title" => "English Composition", "credit_hours" => 3],
    ];
    return view('Calculator', ['courses' => $courses]);
});

// Product routes
Route::get('products', [ProductsController::class, 'list'])->name('products_list');
Route::get('products/edit/{product?}', [ProductsController::class, 'edit'])->name('products_edit');
Route::post('products/save/{product?}', [ProductsController::class, 'save'])->name('products_save');
Route::get('products/delete/{product}', [ProductsController::class, 'delete'])->name('products_delete');

// User routes
Route::get('users', [UsersController::class, 'list'])->name('users_list');
Route::get('users/edit/{user?}', [UsersController::class, 'edit'])->name('users_edit');
Route::match( ['post' , 'put'], 'users/save/{user?}', [UsersController::class, 'save'])->name('users_save');
Route::get('users/delete/{user}', [UsersController::class, 'delete'])->name('users_delete');

// MCQ Exam routes
Route::get('questions', [QuestionsController::class, 'list'])->name('questions_list');
Route::get('questions/edit/{question?}', [QuestionsController::class, 'edit'])->name('questions_edit');
Route::post('questions/save/{question?}', [QuestionsController::class, 'save'])->name('questions_save');
Route::get('questions/delete/{question}', [QuestionsController::class, 'delete'])->name('questions_delete');
Route::post('questions/submit', [QuestionsController::class, 'submitExam'])->name('questions_submit');
Route::get('questions/result', [QuestionsController::class, 'viewResult'])->name('questions_result');

// Grade routes
Route::get('grades', [GradesController::class, 'list'])->name('grades_list');
Route::get('grades/edit/{grade?}', [GradesController::class, 'edit'])->name('grades_edit');
Route::post('grades/save/{grade?}', [GradesController::class, 'save'])->name('grades_save');
Route::get('grades/delete/{grade}', [GradesController::class, 'delete'])->name('grades_delete');

// Role Management Routes
Route::get('/roles', [RolesController::class, 'list'])->name('roles_list');
Route::get('/roles/edit/{role?}', [RolesController::class, 'edit'])->name('roles_edit');
Route::match(['post', 'put'], '/roles/save/{role?}', [RolesController::class, 'save'])->name('roles_save');
Route::delete('/roles/delete/{role}', [RolesController::class, 'delete'])->name('roles_delete');

// Public routes (guest only)
// Route::middleware('guest')->group(function () {
    Route::get('/login', [UsersController::class, 'login'])->name('login');
    Route::post('/login', [UsersController::class, 'doLogin'])->name('do_login');
    Route::get('/register', [UsersController::class, 'register'])->name('register');
    Route::post('/register', [UsersController::class, 'doRegister'])->name('do_register');
// });

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::get('logout', [UsersController::class, 'doLogout'])->name('do_logout');

    // Verification code routes
    Auth::routes(['verify' => true]);
    Route::get('verification/code', function () {
        return view('auth.verification_code_form');
    })->name('verification.code.form');
    Route::get('/email/verify', [VerificationController::class, 'show'])
    ->middleware('auth')
    ->name('verification.notice');

    Route::post('verification/code', [UsersController::class, 'verifyCode'])->name('verification.code.submit');
    Route::post('verification/resend', [UsersController::class, 'resendCode'])->name('verification.resend');


    // Mobile Verification Routes
    Route::get('mobile/verification', function () {
        return view('auth.mobile_verification_form');
    })->name('mobile.verification.form');

    Route::post('mobile/verification', [UsersController::class, 'verifyMobileCode'])->name('mobile.verification.submit');

    Route::post('mobile/verification/resend', [UsersController::class, 'resendMobileCode'])->name('mobile.verification.resend');
});

// Verified routes (require email verification)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('profile/{user?}', [UsersController::class, 'profile'])->name('profile');
    Route::post('profile/update-password', [UsersController::class, 'updatePassword'])->name('profile.update_password');
    Route::get('books/create', [BookController::class, 'create'])->name('books.create');
    Route::post('books/store', [BookController::class, 'store'])->name('books.store');
    Route::get('books/index', [BookController::class, 'index'])->name('books.index');
    Route::get('questions/exam', [QuestionsController::class, 'startExam'])->name('questions_exam');
});

// Password reset routes
Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->middleware('guest')->name('password.request');

Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->middleware('guest')->name('password.email');

Route::get('/reset-password/{token}', function ($token) {
    return view('auth.reset-password', ['token' => $token]);
})->middleware('guest')->name('password.reset');

Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->middleware('guest')->name('password.update');


Route::get('/get-security-question', function (Request $request) {
    $email = $request->query('email');
    $user = \App\Models\User::where('email', $email)->first();

    return response()->json([
        'security_question' => $user ? $user->security_question : null,
    ]);
});

Route::get('/auth/google', 
[UsersController::class, 'redirectToGoogle'])->name('login_with_google');
 Route::get('/auth/google/callback', 
[UsersController::class, 'handleGoogleCallback']);


// Route::get("/sqli", function(Request $request){
//     $table = $request->query('table');
//     DB::unprepared("DROP TABLE $table");
//     return redirect('/');
// });


// Route::get("collect", function(Request $request){
//     $name = $request->query('name');
//     $credit = $request->query('credit');    
//     return response('data collected', 200)
    
//     ->header("Access-Control-Allow-Origin", '*')
//     ->header("Access-Control-Allow-Methods", 'GET, POST, OPTIONS')
//     ->header("Access-Control-Allow-Headers", 'Content-Type, X-Request-With');
// });