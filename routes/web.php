<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BorrowingController;

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

    Route::get('/categories', [CategoryController::class, 'index'])
        ->name('categories.index');

Route::middleware('role:admin')->group(function () {
    Route::resource('categories', CategoryController::class)
        ->except(['index']);

    Route::middleware('can:manage-users')->group(function () {
        Route::resource('users', UserController::class);
    });
});

    Route::middleware('role:admin,petugas')->group(function () {
        Route::resource('borrowings', BorrowingController::class)
            ->only(['index', 'create', 'store', 'show']);
        Route::post(
            '/borrowings/{borrowing}/return',
            [BorrowingController::class, 'returnBook']
        )->name('borrowings.return');
        Route::resource('books', BookController::class);
        Route::resource('members', MemberController::class);
    });
});