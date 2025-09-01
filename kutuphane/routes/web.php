<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BulkImportController;

Route::get('/', function () {
    return view('index');
});
//auth routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

//dashboard protected routes
Route::get('/dashboard', function (){
    return view('dashboard');
})->middleware('auth')->name('dashboard');

//admin routes
Route::middleware(['auth', 'admin'])->group(function(){
    Route::resource('users', UserController::class);
    Route::get('/books/create', [BookController::class, 'create'])->name('books.create');
    Route::post('/books', [BookController::class, 'store'])->name('books.store');
    Route::get('/books/{id}/edit', [BookController::class, 'edit'])->name('books.edit');
    Route::put('/books/{id}', [BookController::class, 'update'])->name('books.update');
    Route::delete('/books/{id}', [BookController::class, 'destroy'])->name('books.destroy');
    
    // Bulk Import routes - Facade Pattern kullanıyor
    Route::get('/bulk-import', [BulkImportController::class, 'index'])->name('bulk-import.index');
    Route::get('/bulk-import/create', [BulkImportController::class, 'create'])->name('bulk-import.create');
    Route::post('/bulk-import', [BulkImportController::class, 'store'])->name('bulk-import.store');
    Route::get('/bulk-import/{importHistory}/status', [BulkImportController::class, 'showStatus'])->name('bulk-import.status');
    Route::get('/bulk-import/{importHistory}/status-api', [BulkImportController::class, 'getStatus'])->name('bulk-import.status-api');
    Route::get('/bulk-import/history', [BulkImportController::class, 'history'])->name('bulk-import.history');
});

//book routes
Route::middleware(['auth'])->group(function(){
    Route::get('/books', [BookController::class, 'index'])->name('books.index');
    Route::get('/books/search', [BookController::class, 'search'])->name('books.search');
    Route::get('/books/favorite', [BookController::class, 'showFavoriteBooks'])->name('books.favorite');
    Route::post('/books/{book}/favorite', [BookController::class, 'addToFavorite'])->name('books.addToFavorite');
    Route::delete('/books/{book}/favorite', [BookController::class, 'removeFromFavorite'])->name('books.removeFromFavorite');
    Route::get('/books/{id}', [BookController::class, 'show'])->name('books.show');
});
