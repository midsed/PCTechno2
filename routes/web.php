<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
  DashboardController, ProductController, CustomerController,
  TransactionController, SalesController, UserController, LogController
};

Route::get('/', fn() => redirect()->route('login'));

require __DIR__.'/auth.php';

Route::middleware(['auth'])->group(function () {

  // Dashboard: Admin + Employee (Cashier can also see it if you want; optional)
  Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard')
    ->middleware('role:admin,employee,cashier');

  // Inventory + Customers: Admin + Employee
  Route::resource('products', ProductController::class)->middleware('role:admin,employee');
  Route::resource('customers', CustomerController::class)->middleware('role:admin,employee');

  // Transactions:
  // Cashier can ADD and VIEW Transactions table
  Route::get('/transactions', [TransactionController::class, 'index'])
    ->name('transactions.index')
    ->middleware('role:admin,employee,cashier');

  Route::get('/transactions/create', [TransactionController::class, 'create'])
    ->name('transactions.create')
    ->middleware('role:admin,employee,cashier');

  Route::post('/transactions', [TransactionController::class, 'store'])
    ->name('transactions.store')
    ->middleware('role:admin,employee,cashier');

  // Sales: Cashier can VIEW sales, Admin/Employee too
  Route::get('/sales', [SalesController::class, 'index'])
    ->name('sales.index')
    ->middleware('role:admin,employee,cashier');

  // Users + Logs: Admin only
  Route::resource('users', UserController::class)->middleware('role:admin');
  Route::get('/logs', [LogController::class, 'index'])->name('logs.index')->middleware('role:admin');

});
