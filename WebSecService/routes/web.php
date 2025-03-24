<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\ProductsController;
use App\Http\Controllers\Web\UsersController;
use App\Http\Controllers\Web\QuestionsController;
use App\Http\Controllers\Web\GradesController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Web\BookController;
use App\Http\Controllers\Web\Controller;
use App\Http\Controllers\Web\PermissionsController;
use App\Http\Controllers\Web\RolesController;

Route::get('/', function () 
{
    return view('welcome');
})->name('home');

// User routes
Route::get('users', [UsersController::class, 'list'])->name('users_list');
Route::get('users/edit/{user?}', [UsersController::class, 'edit'])->name('users_edit');
Route::post('users/save/{user?}', [UsersController::class, 'save'])->name('users_save');
Route::delete('users/delete/{user}', [UsersController::class, 'delete'])->name('users_delete');
Route::get('users/customers', [UsersController::class, 'customers'])->name('users_customers');
Route::post('users/add-credit/{user}', [UsersController::class, 'addCredit'])->name('users_add_credit');
Route::get('users/purchases', [UsersController::class, 'purchases'])->name('users_purchases');
Route::get('profile', [UsersController::class, 'profile'])->name('profile');

// Product routes
Route::get('products', [ProductsController::class, 'list'])->name('products_list');
Route::get('products/edit/{product?}', [ProductsController::class, 'edit'])->name('products_edit');
Route::post('products/save/{product?}', [ProductsController::class, 'save'])->name('products_save');
Route::delete('products/delete/{product}', [ProductsController::class, 'delete'])->name('products_delete');
Route::post('products/purchase/{product}', [ProductsController::class, 'purchase'])->name('products_purchase');

// Role routes
Route::get('/roles', [RolesController::class, 'list'])->name('roles_list');
Route::get('/roles/edit/{role?}', [RolesController::class, 'edit'])->name('roles_edit');
Route::match(['post', 'put'], '/roles/save/{role?]', [RolesController::class, 'save'])->name('roles_save');
Route::delete('/roles/delete/{role}', [RolesController::class, 'delete'])->name('roles_delete');

// Permission routes
Route::get('/permissions', [PermissionsController::class, 'list'])->name('permissions_list');
Route::get('/permissions/edit/{permission?}', [PermissionsController::class, 'edit'])->name('permissions_edit');
Route::match(['post', 'put'], '/permissions/save/{permission?]', [PermissionsController::class, 'save'])->name('permissions_save');
Route::delete('/permissions/delete/{permission}', [PermissionsController::class, 'delete'])->name('permissions_delete');

// MCQ Exam routes
Route::get('questions', [QuestionsController::class, 'list'])->name('questions_list');
Route::get('questions/edit/{question?}', [QuestionsController::class, 'edit'])->name('questions_edit');
Route::post('questions/save/{question?}', [QuestionsController::class, 'save'])->name('questions_save');
Route::get('questions/delete/{question}', [QuestionsController::class, 'delete'])->name('questions_delete');
Route::get('questions/exam', [QuestionsController::class, 'startExam'])->name('questions_exam');
Route::post('questions/submit', [QuestionsController::class, 'submitExam'])->name('questions_submit');
Route::get('questions/result', [QuestionsController::class, 'viewResult'])->name('questions_result');

// Book routes
Route::get('books', [BookController::class, 'index'])->name('books.index');
Route::get('books/create', [BookController::class, 'create'])->name('books.create');
Route::post('books', [BookController::class, 'store'])->name('books.store');

// Authentication routes
Route::get('login', [UsersController::class, 'login'])->name('login');
Route::post('login', [UsersController::class, 'doLogin'])->name('do_login');
Route::get('logout', [UsersController::class, 'doLogout'])->name('do_logout');
Route::get('register', [UsersController::class, 'register'])->name('register');
Route::post('register', [UsersController::class, 'doRegister'])->name('do_register');

Route::get('/even', function () 
{
    return view('even');
});

Route::get('/prime', function () 
{
    return view('prime');
});


Route::get('/MiniTest', function () 
{
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


Route::get('/Transcript', function () 
{
    $transcript = [
        (object)["course" => "Mathematics", "grade" => "A"],
        (object)["course" => "Physics", "grade" => "B+"],
        (object)["course" => "Chemistry", "grade" => "A-"],
        (object)["course" => "Biology", "grade" => "B"],
        (object)["course" => "Computer Science", "grade" => "A"]
    ];
    return view('Transcript', compact("transcript"));
});

Route::get('/Products', function () 
{
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

Route::get('/Calculator', function () 
{
    $courses = [
        ["code" => "CS101", "title" => "Introduction to Computer Science", "credit_hours" => 3],
        ["code" => "MATH101", "title" => "Calculus I", "credit_hours" => 4],
        ["code" => "PHYS101", "title" => "Physics I", "credit_hours" => 4],
        ["code" => "ENG101", "title" => "English Composition", "credit_hours" => 3],
    ];
    return view('Calculator' , ['courses' => $courses]);
});

Route::get('grades', [GradesController::class, 'list'])->name('grades_list');
Route::get('grades/edit/{grade?}', [GradesController::class, 'edit'])->name('grades_edit');
Route::post('grades/save/{grade?}', [GradesController::class, 'save'])->name('grades_save');
Route::get('grades/delete/{grade}', [GradesController::class, 'delete'])->name('grades_delete');

Route::get('/home', function () 
{
    return view('home');
})->middleware(['auth', 'verified']);

Route::post('/email/resend', [VerificationController::class, 'resend'])->name('verification.resend');