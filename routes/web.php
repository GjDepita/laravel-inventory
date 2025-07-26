<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TimeLogController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;
use App\Models\Product;
use App\Models\TimeLog;
use App\Http\Middleware\PreventRegistrationIfUsersExist;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Http\Request;

// Public Route
Route::get('/', function () {
    return view('welcome');
    // return view('dashboard', compact('timeLogs', 'products'));  
});

Route::middleware(['auth'])->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Admin Dashboard (Optional Separate View)
Route::middleware(['auth', RoleMiddleware::class . ':admin'])->get('/admin/dashboard', function () {
    return redirect('/dashboard'); // Reuse unified dashboard
})->name('admin.dashboard');

// User Dashboard (Optional Separate View)
Route::middleware(['auth', RoleMiddleware::class . ':user'])->get('/user/dashboard', function () {
    return redirect('/dashboard'); // Reuse unified dashboard
})->name('user.dashboard');

// Admin User Management
Route::middleware(['auth', RoleMiddleware::class . ':admin'])->group(function () {
    Route::get('/admin/create-user', [AdminController::class, 'createUserPage'])->name('admin.register.form');
    Route::post('/admin/create-user', [AdminController::class, 'storeNewUser']);
    Route::get('/admin/time-logs', [TimeLogController::class, 'adminLogs'])->name('admin.time.logs');
});

// Profile Management (All Authenticated Users)
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Products Resource Routes
Route::middleware(['auth'])->resource('products', ProductController::class);

// Time Logs Routes
Route::middleware(['auth'])->group(function () {
    Route::post('/clock-in', [TimeLogController::class, 'clockIn'])->name('clock.in');
    Route::post('/clock-out', [TimeLogController::class, 'clockOut'])->name('clock.out');
});

Route::get('/products/module/{module}', [ProductController::class, 'showModuleProducts'])
    ->middleware(['auth'])
    ->name('products.module');

Route::get('/products/{product}', [ProductController::class, 'show']);

Route::middleware(['auth'])->group(function () {
    Route::post('/products/{product}/update-location', [ProductController::class, 'updateModuleLocation'])
        ->name('products.updateLocation');
});

// Registration Middleware
// Prevent registration if users already exist
Route::middleware(PreventRegistrationIfUsersExist::class)->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('/register', [RegisteredUserController::class, 'store']);
});

Route::post('/products/save-test-result/{id}', [ProductController::class, 'saveTestResult']);

Route::post('/products/save-labeling/{id}', [ProductController::class, 'saveLabelingData']);

require __DIR__.'/auth.php';
