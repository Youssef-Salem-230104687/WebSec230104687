<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
