<?php

use App\Http\Controllers\MainController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\ItemController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
| resource
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::view('home','user.home')->name('user.home');
    Route::get('/links', [MainController::class, 'link'])->name('user.links');
});
Route::group(['middleware'=>['Admin']],function (){
    Route::group(['prefix'=>'main'],function (){
        Route::view('branches','admin.branch')->name('branches');
        Route::view('jobs','admin.job')->name('jobs');
        Route::view('teams','admin.team')->name('teams');
        Route::view('positions','admin.position')->name('positions');
        Route::view('events','admin.event')->name('events');
        Route::view('links','admin.link')->name('links');
    });

    Route::group(['prefix'=>'user'],function (){
        Route::view('statuses','admin.status')->name('statuses');
        Route::view('categories','admin.category')->name('categories');
        Route::view('nationalities','admin.nationality')->name('nationalities');
        Route::view('maritalStatuses','admin.maritalStatus')->name('maritalStatuses');
        Route::view('qualifications','admin.qualification')->name('qualifications');
        Route::view('degrees','admin.degree')->name('degrees');
        Route::view('check-types','admin.checkType')->name('checkTypes');
        Route::view('users','admin.user')->name('users');
        Route::view('approval','admin.approval')->name('approval');
    });
});

require __DIR__.'/auth.php';
