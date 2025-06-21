<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\{
    IndexController,
    ShopController,
    AboutController,
    ContactController,
    OrderController as WebOrderController,
};
use App\Http\Controllers\Admin\{
    IndexController as AdminIndexController,
    ProductController,
    OrderController,
    SettingsController,
    AuthController,
};

/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [IndexController::class, 'index'])->name('web.view.index');
Route::get('/shop', [ShopController::class, 'view'])->name('web.view.shop');
Route::get('/about-us', [AboutController::class, 'view'])->name('web.view.about');
Route::get('/contact', [ContactController::class, 'view'])->name('web.view.contact');
Route::post('/contact', [ContactController::class, 'submitContact'])->name('web.contact.submit');
Route::get('/orders-web', [WebOrderController::class, 'view'])->name('web.orders.index');

// New route to store the order
Route::post('/orders', [WebOrderController::class, 'storeWebOrders'])->name('web.orders.store');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/home', [AdminIndexController::class, 'index'])->name('admin.dashboard');

    // Products Management - Individual Routes
       Route::get('/admin/products', [ProductController::class, 'index'])->name('admin.products.index');
    Route::get('/admin/products/create', [ProductController::class, 'create'])->name('admin.products.create'); // Add this
    Route::post('/admin/products', [ProductController::class, 'store'])->name('admin.products.store');
    Route::get('/admin/products/{product}', [ProductController::class, 'show'])->name('admin.products.show'); // Add this
    Route::get('/admin/products/{product}/edit', [ProductController::class, 'edit'])->name('admin.products.edit');
    Route::put('/admin/products/{product}', [ProductController::class, 'update'])->name('admin.products.update');
    Route::delete('/admin/products/{product}', [ProductController::class, 'destroy'])->name('admin.products.destroy');
    
    // Orders
    Route::get('/admin/orders', [OrderController::class, 'index'])->name('admin.orders.index');
    Route::get('/admin/orders/{id}', [OrderController::class, 'show'])->name('admin.orders.show');
Route::put('/admin/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');

    // Banners


    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::put('/settings/banners', [SettingsController::class, 'updateBanners'])->name('settings.update.banners');
    Route::put('/settings/general', [SettingsController::class, 'updateSettings'])->name('settings.update.general');
    Route::get('/queries', [\App\Http\Controllers\QueryController::class, 'index'])->name('admin.queries.index');
    // Logout Route
    Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');
});

Route::get('/login', function () {
    return view('Auth.login');
})->name('login');


Route::post('/login', [AuthController::class, 'login'])->name('admin.login');
