<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Notifications\DatabaseNotification;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::view('/', 'welcome');



Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::middleware(['auth'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    // Transactions
    Route::get('/transactions', function () {
        return view('transactions.index');
    })->name('transactions.index');
    Route::get('/transactions/create', function () {
        return view('transactions.create');
    })->name('transactions.create');
    Route::get('/transactions/{transaction}/view/{notification?}', function (\App\Models\Transaction $transaction, $notification = null) {
        if ($notification) {
            $note = auth()->user()->notifications()->findOrFail($notification);
            $note->markAsRead();
        }
        return view('transactions.show', compact('transaction'));
    })->name('transactions.show');
    // Accounts
    Route::get('/accounts', function () {
        return view('accounts.index');
    })->name('accounts.index');
    Route::get('/accounts/import', function () {
        return view('accounts.imports');
    })->name('accounts.import');
});

require __DIR__ . '/auth.php';
