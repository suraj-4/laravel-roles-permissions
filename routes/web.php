<?php

use App\Http\Controllers\articleController;
use App\Http\Controllers\permissionController;
use App\Http\Controllers\roleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\userController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Permission Routes
    Route::get('/permissions', [permissionController::class, 'showPermissionPage'])->name('permissions.index');
    Route::get('/permissions/create', [permissionController::class, 'permissionCreate'])->name('permissions.create');
    Route::post('/permissions/store', [permissionController::class, 'permissionStore'])->name('permissions.store');
    Route::get('/permissions/{id}/edit', [permissionController::class, 'permissionEdit'])->name('permissions.edit');
    Route::post('/permissions/{id}', [permissionController::class, 'permissionUpdate'])->name('permissions.update');
    Route::delete('/permissions', [permissionController::class, 'permissionDestroy'])->name('permissions.delete');

    // Roles Routes
    Route::get('/roles', [roleController::class, 'showRoles'])->name('roles.index');
    Route::get('/roles/create', [roleController::class, 'createRole'])->name('roles.create');
    Route::post('/roles/store', [roleController::class, 'storeRole'])->name('roles.store');
    Route::get('/roles/{id}/edit', [roleController::class, 'editRole'])->name('roles.edit');
    Route::post('/roles/{id}', [roleController::class, 'updateRoles'])->name('roles.update');
    Route::delete('/roles', [roleController::class, 'destroyRoles'])->name('roles.delete');

    // Article Routes
    Route::get('/article', [articleController::class, 'showArticle'])->name('article.index');
    Route::get('/article/create', [articleController::class, 'createArticle'])->name('article.create');
    Route::post('/article/store', [articleController::class, 'storeArticle'])->name('article.store');
    Route::get('/article/{id}/edit', [articleController::class, 'editArticle'])->name('article.edit');
    Route::post('/article/{id}', [articleController::class, 'updateArticle'])->name('article.update');
    Route::delete('/article', [articleController::class, 'destroyArticle'])->name('article.delete');

    // Users Routes
    Route::get('/users', [userController::class, 'showUsers'])->name('users.index');
    // Route::get('/users/create', [userController::class, 'createUsers'])->name('users.create');
    // Route::post('/users/store', [userController::class, 'storeUsers'])->name('users.store');
    Route::get('/users/{id}/edit', [userController::class, 'editUsers'])->name('users.edit');
    Route::post('/users/{id}', [userController::class, 'updateUsers'])->name('users.update');
    // Route::delete('/users', [userController::class, 'destroyUsers'])->name('users.delete');

});

require __DIR__.'/auth.php';
