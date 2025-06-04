<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BungalowController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PayPalController;
use App\Http\Controllers\AdminController; // Make sure this is imported
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Route;

// Publicly accessible Bungalow routes
Route::get('/', [BungalowController::class, 'index'])->name('root');
Route::get('/bungalows', [BungalowController::class, 'index'])->name('bungalows.index');
Route::get('/bungalows/{id}', [BungalowController::class, 'show'])->name('bungalows.show');


// Auth routes for user registration and login (provided by Laravel Breeze/Jetstream)
require __DIR__.'/auth.php';


// Routes that require user authentication
Route::middleware('auth')->group(function () {
    // User Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // User Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['verified'])->name('dashboard');

    // Booking related routes
    Route::get('/book/{bungalowId}', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/book/confirm-and-pay', [BookingController::class, 'confirmAndPay'])->name('booking.confirm_and_pay'); // Corrected method name here
    Route::get('/my-reservations', [BookingController::class, 'userBookings'])->name('user.reservations');

    // PayPal transaction routes
    Route::prefix('transaction')->name('transaction.')->group(function () {
        // Route::get('/', [PayPalController::class, 'createTransaction'])->name('create'); // This route might be unused or for different flow
        Route::get('/process', [PayPalController::class, 'processTransaction'])->name('process');
        Route::get('/success', [PayPalController::class, 'successTransaction'])->name('success');
        Route::get('/cancel', [PayPalController::class, 'cancelTransaction'])->name('cancel');
        // Route::get('/finish', [PayPalController::class, 'finishTransaction'])->name('finish'); // This route might be unused or for different flow
    });

    // Admin Dashboard and related routes - Restricted to ADMIN_EMAIL via middleware
    Route::middleware('admin.access')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // New Bungalow Management Routes for Admin
        // Route to show a list of bungalows in the admin panel
        Route::get('/bungalows', [AdminController::class, 'bungalowsIndex'])->name('bungalows.index');
        // Route to show the form for creating a new bungalow
        Route::get('/bungalows/create', [AdminController::class, 'createBungalow'])->name('bungalows.create');
        // Route to store a newly created bungalow
        Route::post('/bungalows', [AdminController::class, 'storeBungalow'])->name('bungalows.store');
        // Route to delete a bungalow
        Route::delete('/bungalows/{id}', [AdminController::class, 'destroyBungalow'])->name('bungalows.destroy');
        // Optional: Route to edit a bungalow
        // Route::get('/bungalows/{id}/edit', [AdminController::class, 'editBungalow'])->name('bungalows.edit');
        // Optional: Route to update a bungalow
        // Route::put('/bungalows/{id}', [AdminController::class, 'updateBungalow'])->name('bungalows.update');
    });


    // Route for sending message to admin
    Route::post('/contact-admin', [ContactController::class, 'sendMessage'])->name('contact.admin');

    // Route to display the contact form
    Route::get('/contact-admin/create', [ContactController::class, 'showContactForm'])->name('contact.admin.create');

    // Message routes
    Route::prefix('messages')->name('messages.')->group(function () {
        Route::get('/', [MessageController::class, 'index'])->name('index'); // User's inbox
        Route::get('/create/{receiver}', [MessageController::class, 'create'])->name('create'); // Form to send message to a specific user
        Route::post('/send/{receiver}', [MessageController::class, 'store'])->name('store'); // Store message
        Route::get('/{message}', [MessageController::class, 'show'])->name('show'); // View a specific message
    });
});
