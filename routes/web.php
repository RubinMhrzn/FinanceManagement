<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ManagerController;

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;


/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Login
Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login']);


// Register
Route::get('/register', [AuthController::class, 'showRegister'])
    ->name('register');

Route::post('/register', [AuthController::class, 'register']);


/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Logout
    |--------------------------------------------------------------------------
    */

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');


    /*
    |--------------------------------------------------------------------------
    | User Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/dashboard',
        [DashboardController::class, 'index']
    )->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | User Accounts
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'accounts',
        AccountController::class
    );


    /*
    |--------------------------------------------------------------------------
    | User Categories
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'categories',
        CategoryController::class
    );


    /*
    |--------------------------------------------------------------------------
    | User Transactions
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'transactions',
        TransactionController::class
    );


    /*
    |--------------------------------------------------------------------------
    | MANAGER ROUTES
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:manager')
        ->prefix('manager')
        ->name('manager.')
        ->group(function () {

            /*
            |--------------------------------------------------------------------------
            | Manager Dashboard
            |--------------------------------------------------------------------------
            */

            Route::get(
                '/dashboard',
                [ManagerController::class, 'dashboard']
            )->name('dashboard');


            /*
            |--------------------------------------------------------------------------
            | All User Accounts
            |--------------------------------------------------------------------------
            */

            Route::get(
                '/accounts',
                [ManagerController::class, 'accounts']
            )->name('accounts.index');


            /*
            |--------------------------------------------------------------------------
            | Pending Transactions
            |--------------------------------------------------------------------------
            */

            Route::get(
                '/transactions',
                [ManagerController::class, 'index']
            )->name('transactions.index');


            /*
            |--------------------------------------------------------------------------
            | Approve Transaction
            |--------------------------------------------------------------------------
            */

            Route::put(
                '/transactions/{transaction}/approve',
                [ManagerController::class, 'approve']
            )->name('transactions.approve');


            /*
            |--------------------------------------------------------------------------
            | Reject Transaction
            |--------------------------------------------------------------------------
            */

            Route::put(
                '/transactions/{transaction}/reject',
                [ManagerController::class, 'reject']
            )->name('transactions.reject');
        });


    /*
    |--------------------------------------------------------------------------
    | ADMIN ROUTES
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:admin')
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {

            /*
            |--------------------------------------------------------------------------
            | Admin Dashboard
            |--------------------------------------------------------------------------
            */

            Route::get(
                '/dashboard',
                [AdminDashboardController::class, 'index']
            )->name('dashboard');


            /*
            |--------------------------------------------------------------------------
            | Users CRUD
            |--------------------------------------------------------------------------
            */

            Route::resource(
                'users',
                UserController::class
            );


            /*
            |--------------------------------------------------------------------------
            | Roles CRUD
            |--------------------------------------------------------------------------
            */

            Route::resource(
                'roles',
                RoleController::class
            );


            /*
            |--------------------------------------------------------------------------
            | Accounts
            |--------------------------------------------------------------------------
            */

            Route::get(
                '/accounts',
                [AccountController::class, 'adminIndex']
            )->name('accounts.index');


            /*
            |--------------------------------------------------------------------------
            | Categories
            |--------------------------------------------------------------------------
            */

            Route::get(
                '/categories',
                [CategoryController::class, 'adminIndex']
            )->name('categories.index');

            Route::get(
                '/categories/create',
                [CategoryController::class, 'adminCreate']
            )->name('categories.create');

            Route::post(
                '/categories',
                [CategoryController::class, 'adminStore']
            )->name('categories.store');

            Route::get(
                '/categories/{category}/edit',
                [CategoryController::class, 'adminEdit']
            )->name('categories.edit');

            Route::put(
                '/categories/{category}',
                [CategoryController::class, 'adminUpdate']
            )->name('categories.update');

            Route::delete(
                '/categories/{category}',
                [CategoryController::class, 'adminDestroy']
            )->name('categories.destroy');


            /*
            |--------------------------------------------------------------------------
            | Admin Transactions
            |--------------------------------------------------------------------------
            */

            Route::get(
                '/transactions',
                [TransactionController::class, 'adminIndex']
            )->name('transactions.index');

            Route::get(
                '/transactions/{transaction}',
                [TransactionController::class, 'adminShow']
            )->name('transactions.show');


            /*
            |--------------------------------------------------------------------------
            | Approve Transaction
            |--------------------------------------------------------------------------
            */

            Route::put(
                '/transactions/{transaction}/approve',
                [ManagerController::class, 'approve']
            )->name('transactions.approve');


            /*
            |--------------------------------------------------------------------------
            | Reject Transaction
            |--------------------------------------------------------------------------
            */

            Route::put(
                '/transactions/{transaction}/reject',
                [ManagerController::class, 'reject']
            )->name('transactions.reject');
        });
});
