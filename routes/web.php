<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Admin\SongketController;
use App\Http\Controllers\Cart\AddCartItemController;
use App\Http\Controllers\Cart\CartController;
use App\Http\Controllers\Cart\ClearCartController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Order\CancelOrderController;
use App\Http\Controllers\Order\CheckoutController;
use App\Http\Controllers\Order\ConfirmationController;
use App\Http\Controllers\Order\OrderController;
use App\Http\Controllers\Order\PaymentController;
use App\Http\Controllers\Order\ProcessPaymentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Catalog routes
Route::prefix('catalog')->name('catalog.')->group(function () {
    Route::get('/', [CatalogController::class, 'index'])->name('index');
    Route::get('/{songket}', [CatalogController::class, 'show'])->name('show');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/add', AddCartItemController::class)->name('add');
        Route::patch('/{cartItem}', [CartController::class, 'update'])->name('update');
        Route::delete('/{cartItem}', [CartController::class, 'destroy'])->name('destroy');
        Route::delete('/', ClearCartController::class)->name('clear');
    });

    // Checkout routes
    Route::prefix('checkout')->name('checkout.')->group(function () {
        Route::get('/', [CheckoutController::class, 'index'])->name('index');
        Route::post('/', [CheckoutController::class, 'store'])->name('store');
        Route::get('/payment/{order}', PaymentController::class)->name('payment');
        Route::post('/payment/{order}', ProcessPaymentController::class)->name('payment.process');
        Route::get('/confirmation/{order}', ConfirmationController::class)->name('confirmation');
    });

    // Order routes
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::get('/{order}', [OrderController::class, 'show'])->name('show');
        Route::post('/orders/{order}/cancel', CancelOrderController::class)->name('cancel');
    });
});

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', DashboardController::class)
        ->name('dashboard')
        ->middleware(['role:admin,owner,cashier,employee']);



    Route::middleware(['role:admin'])->group(function () {
        Route::prefix('songket')->name('songket.')->group(function () {
            Route::get('/create', [SongketController::class, 'create'])->name('create');
            Route::post('/', [SongketController::class, 'store'])->name('store');
            Route::get('/{songket}/edit', [SongketController::class, 'edit'])->name('edit');
            Route::put('/{songket}', [SongketController::class, 'update'])->name('update');
            Route::delete('/{songket}', [SongketController::class, 'destroy'])->name('destroy');
            Route::patch('/{songket}/toggle-status', [SongketController::class, 'toggleStatus'])->name('toggle-status');
            Route::get('/export/csv', [SongketController::class, 'export'])->name('export');
        });

        // Categories
        Route::prefix('categories')->name('categories.')->group(function () {
            Route::get('/', [CategoryController::class, 'index'])->name('index');
            Route::get('/create', [CategoryController::class, 'create'])->name('create');
            Route::post('/', [CategoryController::class, 'store'])->name('store');
            Route::get('/{category}/edit', [CategoryController::class, 'edit'])->name('edit');
            Route::put('/{category}', [CategoryController::class, 'update'])->name('update');
            Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('destroy');
        });
    });

    Route::middleware(['role:admin,employee'])->group(function () {
        Route::prefix('songket')->name('songket.')->group(function () {
            Route::get('/', [SongketController::class, 'index'])->name('index');
            Route::get('/{songket}', [SongketController::class, 'show'])->name('show');
        });
    });

    // Payment management (Admin/Cashier)
    Route::middleware('role:cashier')->group(function () {
        Route::resource('orders', AdminOrderController::class)->only(['index', 'show', 'destroy']);
        Route::patch('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');
        Route::get('orders-export', [AdminOrderController::class, 'export'])->name('orders.export');
        Route::resource('payments', AdminPaymentController::class)->only(['index', 'show']);
        Route::patch('payments/{payment}/verify', [AdminPaymentController::class, 'verify'])->name('payments.verify');
        Route::get('payments-export', [AdminPaymentController::class, 'export'])->name('payments.export');
    });
});


require __DIR__ . '/auth.php';
