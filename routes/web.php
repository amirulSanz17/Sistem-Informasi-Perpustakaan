
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\UserController;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.process');
});

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return redirect()->route('members.index');
    })->name('home');

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

    Route::resource('members', MemberController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('books', BookController::class);
});

Route::middleware(['auth', 'can:manage-users'])->group(function(){
    Route::resource('users', UserController::class);
});
