<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthorController;

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
    Route::resource('authors', AuthorController::class);
    Route::get('/books/create', [BookController::class, 'create'])->name('books.create');
    Route::post('/books', [BookController::class, 'store'])->name('books.store');
    Route::get('/books/{book}/edit', [BookController::class, 'edit'])->name('books.edit');
    Route::put('/books/{book}', [BookController::class, 'update'])->name('books.update');
    Route::delete('/books/{book}', [BookController::class, 'destroy'])->name('books.destroy');
});

//book routes
Route::middleware(['auth'])->group(function(){
    Route::get('/books', [BookController::class, 'index'])->name('books.index');
    Route::get('/books/search', [BookController::class, 'search'])->name('books.search');
    Route::get('/books/favorite', [BookController::class, 'showFavoriteBooks'])->name('books.favorite');
    Route::post('/books/{book}/favorite', [BookController::class, 'addToFavorite'])->name('books.addToFavorite');
    Route::delete('/books/{book}/favorite', [BookController::class, 'removeFromFavorite'])->name('books.removeFromFavorite');
    Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');
    Route::get('/authors', [AuthorController::class, 'index'])->name('authors.index');
    Route::get('/authors/{author}', [AuthorController::class, 'show'])->name('authors.show');
    Route::get('/authors/search', [AuthorController::class, 'search'])->name('authors.search');
});
