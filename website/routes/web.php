<?php

use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\CategoriesPostController;
use App\Http\Controllers\DashBoardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RoleController;
use App\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use UniSharp\LaravelFilemanager\Facades\Lfm;


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
    return view('template.home');
});

Auth::routes();

Route::get('home', [HomeController::class, 'index'])->name('home');

Route::group(['prefix' => 'laravel-filemanager'], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});


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
    Route::get("admin/user/edit{user}", [AdminUserController::class, "edit"])->name('user.edit');
    Route::post("admin/user/update{user}", [AdminUserController::class, "update"])->name('user.update');

    // end admin user 

    // admin permsision 
    Route::get("admin/permission/add", [PermissionController::class, 'add'])->name('permission.add');
    Route::post("admin/permission/store", [PermissionController::class, 'store'])->name('permission.store');
    Route::get("admin/permission/edit/{id}", [PermissionController::class, "edit"])->name("permission.edit");
    Route::post("admin/permission/update/{id}", [PermissionController::class, "update"])->name("permission.update");
    Route::get("admin/permission/delete/{id}", [PermissionController::class, "delete"])->name("permission.delete");

    //admin role
    Route::get("admin/role/list", [RoleController::class, "getList"])->name("role.list");
    Route::get("admin/role/add", [RoleController::class, "add"])->name("role.add")->can('role.add');
    Route::post("admin/role/store", [RoleController::class, "store"])->name("role.store")->can('role.add');
    Route::get("admin/role/edit/{role}", [RoleController::class, "edit"])->name("role.edit")->can('role.edit');
    Route::post("admin/role/update/{role}", [RoleController::class, "update"])->name("role.update")->can('role.edit');
    Route::get("admin/role/delete/{role}", [RoleController::class, "delete"])->name("role.delete")->can('role.delete');


    //admin module post
    Route::get("admin/post/add", [PostController::class, "add"])->name("post.add");
    Route::get("category/post/add", [CategoriesPostController::class, "add"])->name("category.post.add");
    Route::post("category/post/store", [CategoriesPostController::class, "store"])->name("category.post.store");


});








