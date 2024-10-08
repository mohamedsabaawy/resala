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

Route::middleware(['auth','branch_check'])->group(function () {
    Route::get('branch/change/{id}',function (){
        request()->session()->put('branch_id', request('id'));
        return back();
    })->name('branch_change');
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::view('home','user.home')->name('user.home');
    Route::view('meeting','admin.meeting')->name('user.meeting');
    Route::get('/links', [MainController::class, 'link'])->name('user.links');
    Route::view('users/approval','admin.approval')->name('approval');
    Route::group(['prefix'=>'main'],function (){
        Route::view('branches','admin.branch')->name('branches')->middleware("permission:branch show");
        Route::view('jobs','admin.job')->name('jobs')->middleware("permission:job show");
        Route::view('teams','admin.team')->name('teams')->middleware("permission:team show");
        Route::view('positions','admin.position')->name('positions')->middleware("permission:position show");
        Route::view('events','admin.event')->name('events')->middleware("permission:event show");
        Route::view('links','admin.link')->name('links')->middleware("permission:link show");
    });
    Route::group(['prefix'=>'roles'],function (){
        Route::view('roles','admin.role')->name('roles')->middleware("permission:role show");
        Route::view('roles/users','admin.userRole')->name('roles.users');
        Route::get('permission/{name}',function (){
            $permission = \Spatie\Permission\Models\Permission::create(['name'=>request()->name.' show']);
            $permission = \Spatie\Permission\Models\Permission::create(['name'=>request()->name.' edit']);
            $permission = \Spatie\Permission\Models\Permission::create(['name'=>request()->name.' create']);
            $permission = \Spatie\Permission\Models\Permission::create(['name'=>request()->name.' delete']);
            if ($permission)
                return "the " . request()->name . " has been create";

        });
    });

    Route::group(['prefix'=>'user'],function (){
        Route::view('statuses','admin.status')->name('statuses')->middleware("permission:status show");
        Route::view('categories','admin.category')->name('categories')->middleware("permission:category show");
        Route::view('nationalities','admin.nationality')->name('nationalities')->middleware("permission:nationality show");
        Route::view('maritalStatuses','admin.maritalStatus')->name('maritalStatuses')->middleware("permission:maritalStatus show");
        Route::view('qualifications','admin.qualification')->name('qualifications')->middleware("permission:qualification show");
        Route::view('degrees','admin.degree')->name('degrees')->middleware("permission:degree show");
        Route::view('check-types','admin.checkType')->name('checkTypes')->middleware("permission:checkType show");
        Route::view('users','admin.user')->name('users')->middleware("permission:user show");
    });
});



require __DIR__.'/auth.php';
