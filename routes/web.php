<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\{
    IndexController,
    ShopController,
    AboutController,
    ContactController,
    OrderController as WebOrderController,
    ProductController as WebProductController,
    ReviewController as WebReviewController,
    UserController as WebUserController,
};
use App\Http\Controllers\Admin\{
    IndexController as AdminIndexController,
    ProductController,
    OrderController,
    SettingsController,
    AuthController,
    DealOfTheDayController,
    ThankYouCardController,
    AnnouncementController,
    ReviewController as AdminReviewController,
    UserController as AdminUserController,
};

/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [IndexController::class, 'index'])->name('web.view.index');
Route::get('/shop', [ShopController::class, 'view'])->name('web.view.shop');
Route::get('/product/{product}', [WebProductController::class, 'show'])->name('web.product.show');
Route::get('/about-us', [AboutController::class, 'view'])->name('web.view.about');
Route::get('/contact', [ContactController::class, 'view'])->name('web.view.contact');
Route::post('/contact', [ContactController::class, 'submitContact'])->name('web.contact.submit');

// AI Chatbot Routes
Route::get('/dr-ai', [App\Http\Controllers\ChatbotController::class, 'view'])->name('web.chatbot');
Route::post('/chatbot/recommendations', [App\Http\Controllers\ChatbotController::class, 'getRecommendations'])->name('chatbot.recommendations');
Route::get('/orders-web', [WebOrderController::class, 'view'])->name('web.orders.index');

// Checkout routes
Route::get('/checkout', [WebOrderController::class, 'checkout'])->name('web.checkout');
Route::get('/checkout/product/{product}', [WebOrderController::class, 'checkoutProduct'])->name('web.checkout.product');

// New route to store the order
Route::post('/orders', [WebOrderController::class, 'storeWebOrders'])->name('web.orders.store');

// Review routes
Route::get('/products/{product}/reviews', [WebReviewController::class, 'index'])->name('web.reviews.index');
Route::post('/products/{product}/verify-order', [WebReviewController::class, 'verifyOrder'])->name('web.reviews.verify-order');
Route::post('/products/{product}/reviews', [WebReviewController::class, 'store'])->name('web.reviews.store');
Route::post('/reviews/{review}/helpful', [WebReviewController::class, 'toggleHelpful'])->name('web.reviews.helpful');
Route::post('/reviews/{review}/like', [WebReviewController::class, 'toggleLike'])->name('web.reviews.like');
Route::get('/products/{product}/review-form-data', [WebReviewController::class, 'getFormData'])->name('web.reviews.form-data');

/*
|--------------------------------------------------------------------------
| User Authentication & Profile Routes
|--------------------------------------------------------------------------
*/

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/register', [WebUserController::class, 'showRegistrationForm'])->name('web.user.register.form');
    Route::post('/register', [WebUserController::class, 'register'])->name('web.user.register');
    Route::get('/login', [WebUserController::class, 'showLoginForm'])->name('web.user.login.form');
    Route::post('/login', [WebUserController::class, 'login'])->name('web.user.login');
    
    // Password Reset Routes
    Route::get('/forgot-password', [WebUserController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [WebUserController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [WebUserController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [WebUserController::class, 'resetPassword'])->name('password.update');
});

// Authenticated user routes  
Route::middleware('auth:web')->group(function () {
    Route::post('/user/logout', [WebUserController::class, 'logout'])->name('web.user.logout');
    Route::get('/profile', [WebUserController::class, 'profile'])->name('web.user.profile');
    Route::get('/profile/edit', [WebUserController::class, 'editProfile'])->name('web.user.edit-profile');
    Route::put('/profile', [WebUserController::class, 'updateProfile'])->name('web.user.update-profile');
    Route::get('/profile/change-password', [WebUserController::class, 'showChangePasswordForm'])->name('web.user.change-password');
    Route::put('/profile/change-password', [WebUserController::class, 'updatePassword'])->name('web.user.update-password');
    Route::get('/my-orders', [WebUserController::class, 'orders'])->name('web.user.orders');
    Route::get('/my-reviews', [WebUserController::class, 'reviews'])->name('web.user.reviews');
    Route::delete('/profile/delete', [WebUserController::class, 'deleteAccount'])->name('web.user.delete-account');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['admin'])->group(function () {
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
    Route::get('/admin/orders/{id}/print', [OrderController::class, 'print'])->name('admin.orders.print');
    Route::put('/admin/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');

    // Deal of the Day Management
    Route::get('/admin/deals', [DealOfTheDayController::class, 'index'])->name('admin.deals.index');
    Route::post('/admin/deals', [DealOfTheDayController::class, 'store'])->name('admin.deals.store');
    Route::put('/admin/deals/{deal}', [DealOfTheDayController::class, 'update'])->name('admin.deals.update');
    Route::delete('/admin/deals/{deal}', [DealOfTheDayController::class, 'destroy'])->name('admin.deals.destroy');
    Route::post('/admin/deals/{deal}/toggle-status', [DealOfTheDayController::class, 'toggleStatus'])->name('admin.deals.toggleStatus');

    // Thank You Card Generator
    Route::get('/admin/thank-you-card', [ThankYouCardController::class, 'index'])->name('admin.thank-you-card.index');
    Route::post('/admin/thank-you-card/generate', [ThankYouCardController::class, 'generate'])->name('admin.thank-you-card.generate');
    
    // Enhanced Thank You Cards System
    Route::get('/admin/thank-you-cards', [ThankYouCardController::class, 'index'])->name('admin.thank-you-cards.index');
    Route::get('/admin/thank-you-cards/create', [ThankYouCardController::class, 'create'])->name('admin.thank-you-cards.create');
    Route::post('/admin/thank-you-cards/preview', [ThankYouCardController::class, 'preview'])->name('admin.thank-you-cards.preview');
    Route::post('/admin/thank-you-cards/print', [ThankYouCardController::class, 'print'])->name('admin.thank-you-cards.print');

    // Announcements Management
    Route::get('/admin/announcements', [AnnouncementController::class, 'index'])->name('admin.announcements.index');
    Route::get('/admin/announcements/create', [AnnouncementController::class, 'create'])->name('admin.announcements.create');
    Route::post('/admin/announcements', [AnnouncementController::class, 'store'])->name('admin.announcements.store');
    Route::get('/admin/announcements/{announcement}', [AnnouncementController::class, 'show'])->name('admin.announcements.show');
    Route::get('/admin/announcements/{announcement}/edit', [AnnouncementController::class, 'edit'])->name('admin.announcements.edit');
    Route::put('/admin/announcements/{announcement}', [AnnouncementController::class, 'update'])->name('admin.announcements.update');
    Route::delete('/admin/announcements/{announcement}', [AnnouncementController::class, 'destroy'])->name('admin.announcements.destroy');
    Route::post('/admin/announcements/{announcement}/toggle-status', [AnnouncementController::class, 'toggleStatus'])->name('admin.announcements.toggleStatus');
    Route::post('/admin/announcements/toggle-all-status', [AnnouncementController::class, 'toggleAllStatus'])->name('admin.announcements.toggleAllStatus');

    // Reviews Management
    Route::get('/admin/reviews', [AdminReviewController::class, 'index'])->name('admin.reviews.index');
    Route::get('/admin/reviews/create', [AdminReviewController::class, 'create'])->name('admin.reviews.create');
    Route::post('/admin/reviews', [AdminReviewController::class, 'store'])->name('admin.reviews.store');
    Route::get('/admin/reviews/{review}', [AdminReviewController::class, 'show'])->name('admin.reviews.show');
    Route::get('/admin/reviews/{review}/edit', [AdminReviewController::class, 'edit'])->name('admin.reviews.edit');
    Route::put('/admin/reviews/{review}', [AdminReviewController::class, 'update'])->name('admin.reviews.update');
    Route::delete('/admin/reviews/{review}', [AdminReviewController::class, 'destroy'])->name('admin.reviews.destroy');
    Route::post('/admin/reviews/{review}/toggle-approval', [AdminReviewController::class, 'toggleApproval'])->name('admin.reviews.toggle-approval');
    Route::post('/admin/reviews/bulk-approve', [AdminReviewController::class, 'bulkApprove'])->name('admin.reviews.bulk-approve');
    Route::post('/admin/reviews/bulk-delete', [AdminReviewController::class, 'bulkDelete'])->name('admin.reviews.bulk-delete');

    // Users Management
    Route::get('/admin/users', [AdminUserController::class, 'index'])->name('admin.users.index');
    Route::get('/admin/users/create', [AdminUserController::class, 'create'])->name('admin.users.create');
    Route::post('/admin/users', [AdminUserController::class, 'store'])->name('admin.users.store');
    Route::get('/admin/users/{user}', [AdminUserController::class, 'show'])->name('admin.users.show');
    Route::get('/admin/users/{user}/edit', [AdminUserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/admin/users/{user}', [AdminUserController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{user}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');
    Route::post('/admin/users/{user}/toggle-status', [AdminUserController::class, 'toggleStatus'])->name('admin.users.toggle-status');
    Route::post('/admin/users/bulk-action', [AdminUserController::class, 'bulkAction'])->name('admin.users.bulk-action');

    // Settings & Configuration
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::put('/settings/banners', [SettingsController::class, 'updateBanners'])->name('settings.update.banners');
    Route::put('/settings/general', [SettingsController::class, 'updateSettings'])->name('settings.update.general');
    
    // Category CRUD routes
    Route::post('/settings/categories', [SettingsController::class, 'storeCategory'])->name('settings.categories.store');
    Route::put('/settings/categories/{category}', [SettingsController::class, 'updateCategory'])->name('settings.categories.update');
    Route::delete('/settings/categories/{category}', [SettingsController::class, 'destroyCategory'])->name('settings.categories.destroy');
    
    // Queries Management
    Route::get('/queries', [\App\Http\Controllers\QueryController::class, 'index'])->name('admin.queries.index');
    
    // Logout Route
    Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');
});

Route::get('/admin/login', function () {
    return view('Auth.login');
})->name('login');

Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login');
