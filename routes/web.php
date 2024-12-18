<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;

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


Route::get('/', [PageController::class, 'index']);
Route::get('/faq', function(){
    return view('faq');
})->name('faq');
Route::get('/about', function(){
    return view('about');
})->name('about');

Route::get('/blogs/{id}', [BlogController::class, 'show'])->name('front.blog');
Route::get('/blogs', [BlogController::class, 'all'])->name('front.blog');

Route::post('/user/update/{id}', [HomeController::class, 'updateUser']);
Route::post('/user/update-password/{id}', [HomeController::class, 'updatePassword']);

Route::group(['prefix' => 'admin'], function () {
    Route::group(['middleware' => ['admin-auth']], function () {
        Route::get('/', [HomeController::class, 'Adminindex']);
        Route::get('/counsellors/fetch', [HomeController::class, 'displayCounsellors']);
        Route::get('/blogs/fetch', [BlogController::class, 'displayBlogs']);
        Route::get('/counsellors', [HomeController::class, 'renderCounsellorsPage']);
        Route::get('/counsellors/add', [HomeController::class, 'renderAddCounsellorsPage']);
        // Route::get('/admin/counsellors/add', [CounsellorController::class, 'renderAddCounsellorsPage'])->name('counsellor.add');
        Route::get('/users', [HomeController::class, 'renderUsersPage']);
        Route::get('/users/fetch', [HomeController::class, 'displayUsers']);
        Route::resource('/blogs', BlogController::class);
        Route::get('/counsellor/edit/{id}', [HomeController::class, 'editCounsellor']);
        Route::get('/user/edit/{id}', [HomeController::class, 'editCounsellor']);
        Route::get('/user/view/{id}', [HomeController::class, 'viewUser']);
        Route::post('/counsellors/add', [HomeController::class, 'addCounsellor']);
        Route::post('/counsellor/updat', [HomeController::class,'updateCounsellor']);
        Route::post('/counsellor/delete/{id}', [HomeController::class, 'deleteCounsellor']);
        Route::post('/user/delete/{id}', [HomeController::class, 'deleteCounsellor']);
    });
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/chat', [App\Http\Controllers\ChatController::class, 'index'])->name('chats');
Route::get('/chat/{id}', [App\Http\Controllers\ChatController::class, 'show'])->name('chats');
Route::get('/chat-response/{receiverId}', [App\Http\Controllers\ChatController::class, 'chatResponse'])->name('chats');
Route::post('/chat', [App\Http\Controllers\ChatController::class, 'store'])->name('chats');
