<?php

use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\CategoriesPostController;
use App\Http\Controllers\DashBoardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImageController;
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
//setting
Route::get('/', function () {
    return view('template.home');
});

Auth::routes();

Route::get('home', [HomeController::class, 'index'])->name('home');

Route::group(['prefix' => 'laravel-filemanager'], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});
Route::resource('images', ImageController::class);

Route::post('/upload-image', [PostController::class, 'uploadImage'])->name('upload.route.name');
Route::post('/upload/image', [ImageController::class, 'uploadImage'])->name('upload.image');


//admin
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
    Route::get("admin/post/list", [PostController::class, "list"])->name("post.list");
    Route::get("admin/post/add", [PostController::class, "add"])->name("post.add");
    Route::post("admin/post/store", [PostController::class, "store"])->name("post.store");
    Route::get("admin/post/edit", [PostController::class, "edit"])->name("post.edit");
    Route::post("admin/post/update", [PostController::class, "update"])->name("post.update");
    Route::get("admin/post/delete", [PostController::class, "delete"])->name("post.delete");

    //admin module categories post
    //add
    Route::get("category/post/add", [CategoriesPostController::class, "add"])->name("category.post.add");
    Route::post("category/post/store", [CategoriesPostController::class, "store"])->name("category.post.store");
    
    //show category parent
    Route::get('/category/subcategories/{parentId}', [CategoriesPostController::class, 'getSubcategories']);
    Route::get('/category/subcategories/{parentId}', [CategoriesPostController::class, 'showSubcategories'])->name('category.post.subcategories');

    //update
    // Route::get('category/edit/{id}', [CategoriesPostController::class, 'edit'])->name('category.post.edit');
    Route::put('/category/update/{id}', [CategoriesPostController::class, 'update'])->name('category.post.update');
    Route::get('/category/delete/{id}', [CategoriesPostController::class, 'delete'])->name('category.post.delete');

    //model images
    Route::get('/admin/image/list', [ImageController::class, 'list'])->name('admin.image.list');
    Route::post('/admin/image/store', [ImageController::class, 'store'])->name('admin.image.store');

});








