<?php

use App\Http\Controllers\Dashboard\AdminController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\ImportProductController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\RoleController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => ['auth:admin,web'],
    'as' => 'dashboard.',
    'prefix' => 'admin/dashboard/'
], function () {
    # Start Route Profile
    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');

    Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');
    # End Route Profile

    # Route Dashboard
    Route::get('/', [DashboardController::class, 'index'])
        ->name('home');
    # Start Route SoftDeleted

    Route::get('categories/trash', [CategoryController::class, 'trash'])
        ->name('categories.trash');

    Route::put('categories/{category}/restore', [CategoryController::class, 'restore'])
        ->name('categories.restore');

    Route::delete('categories/{category}/force_delete', [CategoryController::class, 'forceDelete'])
        ->name('categories.force_delete');

    # End Route SoftDeleted

    Route::get('products/import', [ImportProductController::class, 'create'])
        ->name('products.import');
    Route::post('products/import', [ImportProductController::class, 'store'])
        ->name('products.import');

    // Resource
    Route::resources([
        'categories' => CategoryController::class,
        'products' => ProductController::class,
        // 'orders'=>Order::class,
        'admin' => AdminController::class,
        'users' => UserController::class,
        'roles' => RoleController::class,
    ]);
});
