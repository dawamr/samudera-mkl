<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MklController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\SubCateoryController;

Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [ProfileController::class,'dashboard'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('user', UserController::class);
        Route::resource('role', RoleController::class);
        Route::resource('permission', PermissionController::class);
        Route::resource('category', CategoryController::class);
        Route::resource('subcategory', SubCateoryController::class);
        Route::resource('collection', CollectionController::class);
        Route::resource('product', ProductController::class);
        Route::get('/get/subcategory', [ProductController::class,'getsubcategory'])->name('getsubcategory');
        Route::get('/remove-external-img/{id}', [ProductController::class,'removeImage'])->name('remove.image');


        Route::resource('mkl', MklController::class)->parameters([
            'mkl' => 'mkl'
        ]);

        Route::get('mkl-payment-stats', [MklController::class, 'getMTKIPaymentStats'])->name('mkl.payment.stats');
        Route::get('mkl-reason-stats', [MklController::class, 'getMTKIReasonStats'])->name('mkl.reason.stats');
        Route::get('mkl-filter-data', [MklController::class, 'getFilteredData'])->name('mkl.filter.data');
        Route::get('mkl-data-by-reason', [MklController::class, 'getDataByReason'])->name('mkl.data.by.reason');
    });

});
