<?php

use App\Http\Controllers\Users\UserController;
use App\Http\Controllers\Authors\AuthorController;
use App\Http\Controllers\Books\BookController;
use App\User;
use App\Models\Book;
use App\Models\Author;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $totalUsers = User::count();
    $totalBooks = Book::count();
    $totalAuthors = Author::count();

    return view('dashboard', compact('totalUsers', 'totalBooks', 'totalAuthors'));
})->name('dashboard');

Route::get('dashboard', function () {
    return redirect()->route('dashboard');
});

Route::get('login', function(){ return view('auth.login'); })->name('login');
Route::get('register', function(){ return view('auth.register'); })->name('register');

Route::get('users', [UserController::class, 'indexView'])->name('users.index');
Route::get('users/create', [UserController::class, 'createView'])->name('users.create');
Route::get('users/{id}/edit', [UserController::class, 'editView'])->name('users.edit');

Route::get('authors', [AuthorController::class, 'indexView'])->name('authors.index');
Route::get('authors/create', [AuthorController::class, 'createView'])->name('authors.create');
Route::get('authors/{id}/edit', [AuthorController::class, 'editView'])->name('authors.edit');

Route::get('books', [BookController::class, 'indexView'])->name('books.index');
Route::get('books/create', [BookController::class, 'createView'])->name('books.create');
Route::get('books/{id}/edit', [BookController::class, 'editView'])->name('books.edit');


