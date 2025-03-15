<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\ProductsController;
use App\Http\Controllers\Web\UsersController;
use App\Http\Controllers\Web\QuestionsController;
use App\Http\Controllers\Web\GradesController;


Route::get('/', function () {
    return view('welcome');
});

// 1st way
Route::get('/multable', function (Request $request) {
    $j = $request->number;
    $msg = $request->msg;
    // dd($j , $msg);
    return view('multable' , compact("j" , "msg"));
});

// 2nd way
// Route::get('/multable/{number?}', function ($number = 9) {
//     $j = $number;
//     return view('multable' , compact("j"));
// });

// 3rd way
// Route::get('/multable/{number?}', function ($number = null) {
//         $j = $number??2;
//         return view('multable' , compact("j"));
//     });

Route::get('/even', function () {
    return view('even');
});

Route::get('/prime', function () {
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

Route::get('products', [ProductsController::class, 'list'])->name('products_list');
Route::get('products/edit/{product?}', [ProductsController::class, 'edit'])->name('products_edit');
Route::post('products/save/{product?}', [ProductsController::class, 'save'])->name('products_save');
Route::get('products/delete/{product}', [ProductsController::class, 'delete'])->name('products_delete');

Route::get('users', [UsersController::class, 'list'])->name('users_list');
Route::get('users/edit/{user?}', [UsersController::class, 'edit'])->name('users_edit');
Route::post('users/save/{user?}', [UsersController::class, 'save'])->name('users_save');
Route::get('users/delete/{user}', [UsersController::class, 'delete'])->name('users_delete');


// MCQ Exam Routes
Route::get('questions', [QuestionsController::class, 'list'])->name('questions_list');
Route::get('questions/edit/{question?}', [QuestionsController::class, 'edit'])->name('questions_edit');
Route::post('questions/save/{question?}', [QuestionsController::class, 'save'])->name('questions_save');
Route::get('questions/delete/{question}', [QuestionsController::class, 'delete'])->name('questions_delete');
Route::get('questions/exam', [QuestionsController::class, 'startExam'])->name('questions_exam');
Route::post('questions/submit', [QuestionsController::class, 'submitExam'])->name('questions_submit');
Route::get('questions/result', [QuestionsController::class, 'viewResult'])->name('questions_result');


Route::get('grades', [GradesController::class, 'list'])->name('grades_list');
Route::get('grades/edit/{grade?}', [GradesController::class, 'edit'])->name('grades_edit');
Route::post('grades/save/{grade?}', [GradesController::class, 'save'])->name('grades_save');
Route::get('grades/delete/{grade}', [GradesController::class, 'delete'])->name('grades_delete');

Route::get('register', [UsersController::class, 'register'])->name('register');
Route::post('register', [UsersController::class, 'doRegister'])->name('do_register');
Route::get('login', [UsersController::class, 'login'])->name('login');
Route::post('login', [UsersController::class, 'doLogin'])->name('do_login');
Route::get('logout', [UsersController::class, 'doLogout'])->name('do_logout');


// Profile routes
Route::get('profile', [UsersController::class, 'profile'])->name('profile');
Route::post('profile/update-password', [UsersController::class, 'updatePassword'])->name('profile.update_password');