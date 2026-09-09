<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ManagerController extends Controller
{

    public function dashboard()
    {
        // Total regular users
        $totalUsers = User::whereHas('role', function ($query) {
            $query->where('name', 'user');
        })->count();

        // Accounts
        $totalAccounts = Account::count();

        $activeAccounts = Account::where('is_active', true)->count();

        $inactiveAccounts = Account::where('is_active', false)->count();

        // Total balance of active accounts
        $totalBalance = Account::where('is_active', true)
            ->sum('balance');

        // Approved income
        $totalIncome = Transaction::where('status', 'approved')
            ->where('type', 'income')
            ->sum('amount');

        // Approved expenses
        $totalExpenses = Transaction::where('status', 'approved')
            ->where('type', 'expense')
            ->sum('amount');

        // Net savings
        $netSavings = $totalIncome - $totalExpenses;

        // Savings rate
        $savingsRate = $totalIncome > 0
            ? ($netSavings / $totalIncome) * 100
            : 0;

        // Pending transactions
        $pendingTransactions = Transaction::where('status', 'pending')
            ->count();

        $pendingIncome = Transaction::where('status', 'pending')
            ->where('type', 'income')
            ->sum('amount');

        $pendingExpenses = Transaction::where('status', 'pending')
            ->where('type', 'expense')
            ->sum('amount');

        // Recent pending transactions
        $recentPendingTransactions = Transaction::with([
            'user',
            'account',
            'category',
        ])
            ->where('status', 'pending')
            ->latest('transaction_date')
            ->latest('id')
            ->take(8)
            ->get();

        // Monthly income / expenses
        $monthlyData = [];

        for ($month = 1; $month <= 12; $month++) {

            $income = Transaction::where('status', 'approved')
                ->where('type', 'income')
                ->whereMonth('transaction_date', $month)
                ->whereYear('transaction_date', now()->year)
                ->sum('amount');

            $expense = Transaction::where('status', 'approved')
                ->where('type', 'expense')
                ->whereMonth('transaction_date', $month)
                ->whereYear('transaction_date', now()->year)
                ->sum('amount');

            $monthlyData[$month] = [
                'income' => $income,
                'expense' => $expense,
                'savings' => $income - $expense,
            ];
        }

        return view('manager.dashboard', compact(
            'totalUsers',
            'totalAccounts',
            'activeAccounts',
            'inactiveAccounts',
            'totalBalance',
            'totalIncome',
            'totalExpenses',
            'netSavings',
            'savingsRate',
            'pendingTransactions',
            'pendingIncome',
            'pendingExpenses',
            'recentPendingTransactions',
            'monthlyData'
        ));
    }
    /*
    |--------------------------------------------------------------------------
    | All User Accounts
    |--------------------------------------------------------------------------
    */

    public function accounts()
    {
        $accounts = Account::with('user')
            ->latest()
            ->get();

        return view(
            'manager.accounts.index',
            compact('accounts')
        );
    }




    /*
    |--------------------------------------------------------------------------
    | Pending Transactions
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $transactions = Transaction::with([
            'user',
            'account',
            'category',
        ])
            ->where('status', 'pending')
            ->latest('transaction_date')
            ->latest('id')
            ->get();

        return view(
            'manager.transactions.index',
            compact('transactions')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Approve Transaction
    |--------------------------------------------------------------------------
    */

    public function approve(Transaction $transaction)
    {
        if ($transaction->status !== 'pending') {
            return back()->with(
                'error',
                'Only pending transactions can be approved.'
            );
        }

        DB::transaction(function () use ($transaction) {

            $account = $transaction->account()
                ->lockForUpdate()
                ->firstOrFail();

            if (
                $transaction->type === 'expense' &&
                $account->balance < $transaction->amount
            ) {
                throw new \Exception(
                    'Insufficient account balance.'
                );
            }

            if ($transaction->type === 'income') {
                $account->increment(
                    'balance',
                    $transaction->amount
                );
            } else {
                $account->decrement(
                    'balance',
                    $transaction->amount
                );
            }

            $transaction->update([
                'status' => 'approved',
            ]);
        });

        return redirect()
            ->route('admin.transactions.index')
            ->with(
                'success',
                'Transaction approved successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Reject Transaction
    |--------------------------------------------------------------------------
    */

    public function reject(Transaction $transaction)
    {
        if ($transaction->status !== 'pending') {
            return back()->with(
                'error',
                'Only pending transactions can be rejected.'
            );
        }

        $transaction->update([
            'status' => 'rejected',
        ]);

        return redirect()
            ->route('manager.transactions.index')
            ->with(
                'success',
                'Transaction rejected successfully.'
            );
    }
}
