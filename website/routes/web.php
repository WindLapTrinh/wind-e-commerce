<?php

use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\DashBoardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PermissionController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Auth::routes();

Route::get('home', [HomeController::class, 'index'])->name('home');


Route::middleware('auth')->group(function(){
    Route::get("admin", [DashBoardController::class, "show"]);
    Route::get("admin/dashboard", [DashBoardController::class, "show"]);

    // admin/user
    Route::get("admin/user/list", [AdminUserController::class, "list"]);

    //add
    Route::get("admin/user/add", [AdminUserController::class, "add"]);
    Route::post("admin/user/store", [AdminUserController::class, "store"]);

    //delete
    Route::get("admin/user/delete/{id}", [AdminUserController::class, "delete"])->name("delete-user");

    //select option
    Route::get("admin/user/action", [AdminUserController::class, "action"]);

    //update
    Route::get("admin/user/edit{id}", [AdminUserController::class, "edit"])->name('user.edit');
    Route::post("admin/user/update{id}", [AdminUserController::class, "update"])->name('user.update');

    // end admin user 

    // admin permsision 
    Route::get("admin/permission/add", [PermissionController::class, 'add'])->name('permission.add');
    Route::post("admin/permission/store", [PermissionController::class, 'store'])->name('permission.store');

});







