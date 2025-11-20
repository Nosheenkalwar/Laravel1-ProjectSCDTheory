<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController; // Example admin module
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
*/

// Public frontend pages (no auth required)
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/products', [PageController::class, 'products'])->name('products');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/cart', [PageController::class, 'cart'])->name('cart');
Route::get('/checkout', [PageController::class, 'checkout'])->name('checkout');
Route::get('/userlogin', [PageController::class, 'login'])->name('userlogin');
Route::get('/userregister', [PageController::class, 'register'])->name('userregister');
Route::get('/services', [PageController::class, 'services'])->name('services');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/product-details/{id}', [PageController::class, 'details'])->name('product.details');
Route::get('/thankyou' , [PageController::class, 'thankyou'])->name('thankyou');

/*
|--------------------------------------------------------------------------
| Authenticated / Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {

    // Admin Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Breeze Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Example: Admin CRUD routes for products
    Route::prefix('admin')->group(function () {
        Route::get('/products', [ProductController::class, 'index'])->name('admin.products.index');
        Route::get('/products/create', [ProductController::class, 'create'])->name('admin.products.create');
        Route::post('/products/store', [ProductController::class, 'store'])->name('admin.products.store');
        Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('admin.products.edit');
Route::put('/products/{product}', [ProductController::class, 'update'])->name('admin.products.update');
Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('admin.products.destroy');
    });
});



// Include Breeze auth routes
require __DIR__.'/auth.php';