<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;

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
Route::get('/', [HomeController::class, 'index'])->name('index');

Route::get('/profile/{id}/comment/{comment_id}', [HomeController::class, 'showProfile'])->whereNumber('id')->whereNumber('comment_id');
Route::get('/profile/{id}', [HomeController::class, 'showProfile'])->whereNumber('id');

Route::get('/item/{id}/comment/{comment_id}', [HomeController::class, 'showItem'])->whereNumber('id')->whereNumber('comment_id');
Route::get('/item/{id}', [HomeController::class, 'showItem'])->whereNumber('id');


Route::post('/add_comment', [HomeController::class, 'addComment']);
Route::get('/remove_comment/{id}', [HomeController::class, 'removeComment'])->whereNumber('id');
Route::post('/update_comment', [HomeController::class, 'updateComment']);

Route::get('/add_update_item/{id?}', [HomeController::class, 'getFormItem']);
Route::post('/add_item', [HomeController::class, 'addItem']);
Route::post('/update_item', [HomeController::class, 'updateItem'])->whereNumber('id');
Route::get('/remove_item/{id}', [HomeController::class, 'removeItem'])->whereNumber('id');


Route::prefix('/admin')->group(function() {
    
    Route::get('/', [AdminController::class, 'index'])->name('admin');
    
    Route::get('/items', [AdminController::class, 'getItems'])->name('items');
    
    Route::get('/item/{id}', [AdminController::class, 'getItem'])->whereNumber('id')->name('item');
    Route::post('/update_item', [AdminController::class, 'updateItem']);
    
    Route::get('/remove_item/{id}', [AdminController::class, 'removeItem'])->whereNumber('id')->name('remove_item');
    Route::get('/restore_item/{id}',[AdminController::class, 'restoreItem'])->whereNumber('id')->name('restore_item');
    
    
    Route::get('/comments/{item_id}', [AdminController::class, 'getComments'])->whereNumber('item_id')->name('comments');
    Route::get('/comment/{id}', [AdminController::class, 'getComment'])->whereNumber('id')->name('comment');
    Route::post('/comment_update', [AdminController::class, 'updateComment']);
    
    Route::get('/remove_comment/{id}', [AdminController::class, 'removeComment'])->whereNumber('id');
    Route::get('/restore_comment/{id}',[AdminController::class, 'restoreComment'])->whereNumber('id');
    
    
    Route::get('/users', [AdminController::class, 'getUsers'])->name('users');
    Route::get('/user/{id}', [AdminController::class, 'getUser'])->whereNumber('id')->name('user');
    Route::post('/update_user', [AdminController::class, 'updateUser'])->name('update_user');
    Route::get('/remove_user/{id}', [AdminController::class, 'removeUser'])->whereNumber('id')->name('remove_user');
    Route::get('/restore_user/{id}', [AdminController::class, 'restoreUser'])->whereNumber('id')->name('restore_user');
});



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';