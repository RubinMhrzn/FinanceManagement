<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Role;
use App\Models\Transaction;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | User Statistics
        |--------------------------------------------------------------------------
        */

        $totalUsers = User::count();

        $totalAdmins = User::whereHas('role', function ($query) {
            $query->where('name', 'admin');
        })->count();

        $totalManagers = User::whereHas('role', function ($query) {
            $query->where('name', 'manager');
        })->count();

        $totalRegularUsers = User::whereHas('role', function ($query) {
            $query->where('name', 'user');
        })->count();


        /*
        |--------------------------------------------------------------------------
        | Account Statistics
        |--------------------------------------------------------------------------
        */

        $totalAccounts = Account::count();

        $activeAccounts = Account::where('is_active', true)->count();

        $totalBalance = Account::sum('balance');


        /*
        |--------------------------------------------------------------------------
        | Transaction Statistics
        |--------------------------------------------------------------------------
        */

        $totalTransactions = Transaction::count();

        $pendingTransactions = Transaction::where(
            'status',
            'pending'
        )->count();

        $approvedTransactions = Transaction::where(
            'status',
            'approved'
        )->count();

        $rejectedTransactions = Transaction::where(
            'status',
            'rejected'
        )->count();


        /*
        |--------------------------------------------------------------------------
        | Financial Statistics
        |--------------------------------------------------------------------------
        */

        $totalIncome = Transaction::where('status', 'approved')
            ->where('type', 'income')
            ->sum('amount');

        $totalExpenses = Transaction::where('status', 'approved')
            ->where('type', 'expense')
            ->sum('amount');

        $netSavings = $totalIncome - $totalExpenses;


        /*
        |--------------------------------------------------------------------------
        | Recent Transactions
        |--------------------------------------------------------------------------
        */

        $recentTransactions = Transaction::with([
            'user',
            'account',
            'category',
        ])
            ->latest('transaction_date')
            ->latest('id')
            ->take(10)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Recent Pending Transactions
        |--------------------------------------------------------------------------
        */

        $recentPendingTransactions = Transaction::with([
            'user',
            'account',
            'category',
        ])
            ->where('status', 'pending')
            ->latest('transaction_date')
            ->latest('id')
            ->take(5)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Recent Users
        |--------------------------------------------------------------------------
        */

        $recentUsers = User::with('role')
            ->latest()
            ->take(5)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Role Statistics
        |--------------------------------------------------------------------------
        */

        $roles = Role::withCount('users')
            ->orderBy('name')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Monthly Transaction Data
        |--------------------------------------------------------------------------
        */

        $monthlyData = [];

        for ($month = 1; $month <= 12; $month++) {

            $monthlyData[$month] = [

                'income' => Transaction::where(
                    'status',
                    'approved'
                )
                    ->where('type', 'income')
                    ->whereMonth('transaction_date', $month)
                    ->whereYear(
                        'transaction_date',
                        now()->year
                    )
                    ->sum('amount'),

                'expense' => Transaction::where(
                    'status',
                    'approved'
                )
                    ->where('type', 'expense')
                    ->whereMonth('transaction_date', $month)
                    ->whereYear(
                        'transaction_date',
                        now()->year
                    )
                    ->sum('amount'),
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | Admin Dashboard
        |--------------------------------------------------------------------------
        */

        return view(
            'admin.dashboard',
            compact(
                'totalUsers',
                'totalAdmins',
                'totalManagers',
                'totalRegularUsers',

                'totalAccounts',
                'activeAccounts',
                'totalBalance',

                'totalTransactions',
                'pendingTransactions',
                'approvedTransactions',
                'rejectedTransactions',

                'totalIncome',
                'totalExpenses',
                'netSavings',

                'recentTransactions',
                'recentPendingTransactions',
                'recentUsers',

                'roles',
                'monthlyData'
            )
        );
    }
}
