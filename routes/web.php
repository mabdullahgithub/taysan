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
    DealOfTheDayController,
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

// Checkout routes
Route::get('/checkout', [WebOrderController::class, 'checkout'])->name('web.checkout');
Route::get('/checkout/product/{product}', [WebOrderController::class, 'checkoutProduct'])->name('web.checkout.product');

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

    // Deal of the Day Management
    Route::get('/admin/deals', [DealOfTheDayController::class, 'index'])->name('admin.deals.index');
    Route::post('/admin/deals', [DealOfTheDayController::class, 'store'])->name('admin.deals.store');
    Route::put('/admin/deals/{deal}', [DealOfTheDayController::class, 'update'])->name('admin.deals.update');
    Route::delete('/admin/deals/{deal}', [DealOfTheDayController::class, 'destroy'])->name('admin.deals.destroy');
    Route::post('/admin/deals/{deal}/toggle-status', [DealOfTheDayController::class, 'toggleStatus'])->name('admin.deals.toggleStatus');

    // Banners


    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::put('/settings/banners', [SettingsController::class, 'updateBanners'])->name('settings.update.banners');
    Route::put('/settings/general', [SettingsController::class, 'updateSettings'])->name('settings.update.general');
    
    // Category CRUD routes
    Route::post('/settings/categories', [SettingsController::class, 'storeCategory'])->name('settings.categories.store');
    Route::put('/settings/categories/{category}', [SettingsController::class, 'updateCategory'])->name('settings.categories.update');
    Route::delete('/settings/categories/{category}', [SettingsController::class, 'destroyCategory'])->name('settings.categories.destroy');
    
    Route::get('/queries', [\App\Http\Controllers\QueryController::class, 'index'])->name('admin.queries.index');
    // Logout Route
    Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');
});

Route::get('/login', function () {
    return view('Auth.login');
})->name('login');


Route::post('/login', [AuthController::class, 'login'])->name('admin.login');
