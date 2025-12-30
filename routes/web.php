<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
  DashboardController, ProductController, CustomerController,
  TransactionController, SalesController, UserController, LogController
};

Route::get('/', fn() => redirect()->route('login'));
require __DIR__.'/auth.php';

Route::middleware(['auth'])->group(function () {

  Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard')
    ->middleware('role:admin,employee,cashier');

  /**
   * PRODUCTS (Inventory)
   * - DELETE from Active = soft delete (Archive)
   * - Archived tab = onlyTrashed()
   * - Restore action = restore()
   * - Permanent delete = forceDelete() (only if not referenced by transactions)
   */
  Route::resource('products', ProductController::class)
    ->middleware('role:admin,employee');

  Route::patch('/products/{product}/restore', [ProductController::class, 'restore'])
    ->name('products.restore')
    ->middleware('role:admin,employee');

  Route::delete('/products/{product}/force', [ProductController::class, 'forceDelete'])
    ->name('products.forceDelete')
    ->middleware('role:admin,employee');

  /**
   * CUSTOMERS
   * - Same behavior as products
   */
  Route::resource('customers', CustomerController::class)
    ->middleware('role:admin,employee');

  Route::patch('/customers/{customer}/restore', [CustomerController::class, 'restore'])
    ->name('customers.restore')
    ->middleware('role:admin,employee');

  Route::delete('/customers/{customer}/force', [CustomerController::class, 'forceDelete'])
    ->name('customers.forceDelete')
    ->middleware('role:admin,employee');

  // Transactions (Cashier can view + create)
  Route::get('/transactions', [TransactionController::class, 'index'])
    ->name('transactions.index')
    ->middleware('role:admin,employee,cashier');

  Route::get('/transactions/create', [TransactionController::class, 'create'])
    ->name('transactions.create')
    ->middleware('role:admin,employee,cashier');

  Route::post('/transactions', [TransactionController::class, 'store'])
    ->name('transactions.store')
    ->middleware('role:admin,employee,cashier');

  // Sales History
  Route::get('/sales', [SalesController::class, 'index'])
    ->name('sales.index')
    ->middleware('role:admin,employee,cashier');

  // Users + Logs (Admin only)
  Route::resource('users', UserController::class)->middleware('role:admin');
  Route::get('/logs', [LogController::class, 'index'])
    ->name('logs.index')
    ->middleware('role:admin');
});
