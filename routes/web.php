<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Frontend\HomePageController;


Route::get('/', [ HomePageController::class, 'home']);
Route::get('/authuser', function(){
    $user = User::find(1);
    auth()->login($user);
    return auth()->user();
});
/*Admin */

Route::get('/admin/login',[ PageController::class, 'showLogin']);
Route::post('/admin/login',[ PageController::class, 'adminLogin'])->name('admin.login');

Route::group(['prefix'=>'admin', 'middleware'=> ['Admin']],  function(){
    Route::get('/',[ PageController::class, 'showDashboard']);  
    Route::resource('category', CategoryController::class);
    Route::post('category/restore', [CategoryController::class, 'restoreAll'])->name('category.restore');
    Route::resource('product', ProductController::class);
    Route::post('/product-upload', [ProductController::class, 'imageUpload'])->name('product.upload');
    Route::post('product/restore', [ProductController::class, 'restoreAll'])->name('product.restore');
    Route::get('product/add/{id}', [ProductController::class,  'productAdd'])->name('product.add');
    Route::post('product/add/{id}', [ProductController::class,  'storeProductAdd'])->name('product.add');
    Route::get('product-add-transaction', [ProductController::class, 'AddTransaction'])->name('add.transaction');
    Route::get('product/remove/{id}', [ProductController::class,  'productRemove'])->name('product.remove');
    Route::get('/logout',[ PageController::class, 'adminLogout'])->name('admin.logout');  
});

// Auth::routes();
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
