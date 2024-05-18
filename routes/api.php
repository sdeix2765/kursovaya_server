<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\correcttoken;  
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;


Route::get('/images/{image}', function ($image) {
    $path = public_path('uploads/room_class/' . $image);
    if (!File::exists($path)) {
        abort(404);
    }
    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
});

// user routes
Route::get('/room_classes', [\App\Http\Controllers\ApiController::class,'room_classes'])->name('room_classes');
Route::get('/rooms', [\App\Http\Controllers\ApiController::class,'rooms'])->name('rooms');
Route::get('/reviews', [\App\Http\Controllers\ApiController::class,'reviews'])->name('reviews');
Route::post('/addreview', [\App\Http\Controllers\ApiController::class,'addreview'])->name('addreview');
Route::post('/addguest', [\App\Http\Controllers\ApiController::class,'addguest'])->name('addguest');
Route::post('/addbook', [\App\Http\Controllers\ApiController::class,'addbook'])->name('addbook');






// admin routes
Route::middleware(correcttoken::class)->post('/addroom_class', [\App\Http\Controllers\ApiAdminController::class,'addroom_class'])->name('addroom_class');
Route::middleware(correcttoken::class)->post('/addroom', [\App\Http\Controllers\ApiAdminController::class,'addroom'])->name('addroom');



Route::post('/register', [\App\Http\Controllers\APIauthController::class,'register'])->name('register');
Route::post('/login', [\App\Http\Controllers\APIauthController::class,'login'])->name('login');
