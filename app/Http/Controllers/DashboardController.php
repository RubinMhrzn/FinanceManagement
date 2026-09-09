<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | Active Accounts
        |--------------------------------------------------------------------------
        */

        $accounts = $user->accounts()
            ->where('is_active', true)
            ->latest()
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Transactions
        |--------------------------------------------------------------------------
        */

        $transactions = $user->transactions();

        /*
        |--------------------------------------------------------------------------
        | Total Balance
        |--------------------------------------------------------------------------
        */

        $totalBalance = $accounts->sum('balance');

        /*
        |--------------------------------------------------------------------------
        | Total Income
        |--------------------------------------------------------------------------
        */

        $totalIncome = (clone $transactions)
            ->where('status', 'approved')
            ->where('type', 'income')
            ->sum('amount');

        /*
        |--------------------------------------------------------------------------
        | Total Expenses
        |--------------------------------------------------------------------------
        */

        $totalExpenses = (clone $transactions)
            ->where('status', 'approved')
            ->where('type', 'expense')
            ->sum('amount');

        /*
        |--------------------------------------------------------------------------
        | Savings
        |--------------------------------------------------------------------------
        */

        $savings = $totalIncome - $totalExpenses;

        /*
        |--------------------------------------------------------------------------
        | Savings Rate
        |--------------------------------------------------------------------------
        */

        $savingsRate = $totalIncome > 0
            ? ($savings / $totalIncome) * 100
            : 0;

        /*
        |--------------------------------------------------------------------------
        | Pending Transactions
        |--------------------------------------------------------------------------
        */

        $pendingTransactions = (clone $transactions)
            ->where('status', 'pending')
            ->count();

        /*
        |--------------------------------------------------------------------------
        | Recent Transactions
        |--------------------------------------------------------------------------
        */

        $recentTransactions = $user->transactions()
            ->with([
                'account',
                'category',
            ])
            ->latest('transaction_date')
            ->latest('id')
            ->take(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Monthly Income / Expenses
        |--------------------------------------------------------------------------
        */

        $monthlyData = [];

        for ($month = 1; $month <= 12; $month++) {

            $monthlyData[$month] = [

                'income' => (clone $transactions)
                    ->where('status', 'approved')
                    ->where('type', 'income')
                    ->whereMonth('transaction_date', $month)
                    ->whereYear('transaction_date', now()->year)
                    ->sum('amount'),

                'expense' => (clone $transactions)
                    ->where('status', 'approved')
                    ->where('type', 'expense')
                    ->whereMonth('transaction_date', $month)
                    ->whereYear('transaction_date', now()->year)
                    ->sum('amount'),

            ];
        }

        /*
        |--------------------------------------------------------------------------
        | Dashboard View
        |--------------------------------------------------------------------------
        */

        return view('dashboard', compact(
            'accounts',
            'totalBalance',
            'totalIncome',
            'totalExpenses',
            'savings',
            'savingsRate',
            'pendingTransactions',
            'recentTransactions',
            'monthlyData'
        ));
    }
}
