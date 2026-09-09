<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | User Transactions
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $query = Transaction::with([
            'account',
            'category',
        ])
            ->where('user_id', Auth::id());

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by account
        if ($request->filled('account_id')) {
            $query->where('account_id', $request->account_id);
        }

        // Filter by category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $transactions = $query
            ->latest('transaction_date')
            ->latest('id')
            ->get();

        // Accounts for filter dropdown
        $accounts = Account::where('user_id', Auth::id())
            ->where('is_active', true)
            ->latest()
            ->get();

        // Categories for filter dropdown
        $categories = Category::where('user_id', Auth::id())
            ->where('is_active', true)
            ->latest()
            ->get();

        return view(
            'transactions.index',
            compact(
                'transactions',
                'accounts',
                'categories'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Create Transaction
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $accounts = Account::where('user_id', Auth::id())
            ->where('is_active', true)
            ->get();

        $categories = Category::where('user_id', Auth::id())
            ->where('is_active', true)
            ->get();

        return view(
            'transactions.create',
            compact(
                'accounts',
                'categories'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Store Transaction
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $validated = $request->validate([
            'account_id' => [
                'required',
                'exists:accounts,id',
            ],

            'category_id' => [
                'required',
                'exists:categories,id',
            ],

            'amount' => [
                'required',
                'numeric',
                'min:0.01',
            ],

            'type' => [
                'required',
                'in:income,expense',
            ],

            'description' => [
                'nullable',
                'string',
                'max:255',
            ],

            'transaction_date' => [
                'required',
                'date',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Security Check
        |--------------------------------------------------------------------------
        */

        $account = Account::where('id', $validated['account_id'])
            ->where('user_id', Auth::id())
            ->where('is_active', true)
            ->firstOrFail();


        $category = Category::where('id', $validated['category_id'])
            ->where(function ($query) {
                $query->where('user_id', Auth::id())
                    ->orWhereNull('user_id');
            })
            ->where('is_active', true)
            ->firstOrFail();


        /*
        |--------------------------------------------------------------------------
        | Create Transaction
        |--------------------------------------------------------------------------
        */

        Transaction::create([
            'user_id' => Auth::id(),
            'account_id' => $account->id,
            'category_id' => $category->id,
            'amount' => $validated['amount'],
            'type' => $validated['type'],
            'description' => $validated['description'] ?? null,
            'transaction_date' => $validated['transaction_date'],
            'status' => 'pending',
        ]);


        return redirect()
            ->route('transactions.index')
            ->with(
                'success',
                'Transaction submitted successfully and is waiting for approval.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | User Transaction Details
    |--------------------------------------------------------------------------
    */

    public function show(Transaction $transaction)
    {
        abort_unless(
            $transaction->user_id === Auth::id(),
            403
        );

        $transaction->load([
            'account',
            'category',
        ]);

        return view(
            'transactions.show',
            compact('transaction')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Edit Transaction
    |--------------------------------------------------------------------------
    */

    public function edit(Transaction $transaction)
    {
        abort_unless(
            $transaction->user_id === Auth::id(),
            403
        );

        if ($transaction->status !== 'pending') {
            return redirect()
                ->route('transactions.index')
                ->with(
                    'error',
                    'Only pending transactions can be edited.'
                );
        }

        $accounts = Account::where('user_id', Auth::id())
            ->where('is_active', true)
            ->get();

        $categories = Category::where('user_id', Auth::id())
            ->where('is_active', true)
            ->get();

        return view(
            'transactions.edit',
            compact(
                'transaction',
                'accounts',
                'categories'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Update Transaction
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        Transaction $transaction
    ) {
        abort_unless(
            $transaction->user_id === Auth::id(),
            403
        );

        if ($transaction->status !== 'pending') {
            return redirect()
                ->route('transactions.index')
                ->with(
                    'error',
                    'Only pending transactions can be updated.'
                );
        }

        $validated = $request->validate([
            'account_id' => [
                'required',
                'exists:accounts,id',
            ],

            'category_id' => [
                'required',
                'exists:categories,id',
            ],

            'amount' => [
                'required',
                'numeric',
                'min:0.01',
            ],

            'type' => [
                'required',
                'in:income,expense',
            ],

            'description' => [
                'nullable',
                'string',
                'max:255',
            ],

            'transaction_date' => [
                'required',
                'date',
            ],
        ]);


        $account = Account::where('id', $validated['account_id'])
            ->where('user_id', Auth::id())
            ->where('is_active', true)
            ->firstOrFail();


        $category = Category::where('id', $validated['category_id'])
            ->where(function ($query) {
                $query->where('user_id', Auth::id())
                    ->orWhereNull('user_id');
            })
            ->where('is_active', true)
            ->firstOrFail();


        $transaction->update([
            'account_id' => $account->id,
            'category_id' => $category->id,
            'amount' => $validated['amount'],
            'type' => $validated['type'],
            'description' => $validated['description'] ?? null,
            'transaction_date' => $validated['transaction_date'],
        ]);


        return redirect()
            ->route('transactions.index')
            ->with(
                'success',
                'Transaction updated successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Delete Transaction
    |--------------------------------------------------------------------------
    */

    public function destroy(Transaction $transaction)
    {
        abort_unless(
            $transaction->user_id === Auth::id(),
            403
        );

        if ($transaction->status !== 'pending') {
            return redirect()
                ->route('transactions.index')
                ->with(
                    'error',
                    'Only pending transactions can be deleted.'
                );
        }

        $transaction->delete();

        return redirect()
            ->route('transactions.index')
            ->with(
                'success',
                'Transaction deleted successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | ADMIN - All Transactions
    |--------------------------------------------------------------------------
    */

    public function adminIndex(Request $request)
    {
        $query = Transaction::with([
            'user',
            'account',
            'category',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Filter by Status
        |--------------------------------------------------------------------------
        */

        if ($request->filled('status')) {
            $query->where(
                'status',
                $request->status
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Filter by Type
        |--------------------------------------------------------------------------
        */

        if ($request->filled('type')) {
            $query->where(
                'type',
                $request->type
            );
        }


        $transactions = $query
            ->latest('transaction_date')
            ->latest('id')
            ->get();


        return view(
            'admin.transactions.index',
            compact('transactions')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ADMIN - View Transaction
    |--------------------------------------------------------------------------
    */

    public function adminShow(Transaction $transaction)
    {
        $transaction->load([
            'user',
            'account',
            'category',
        ]);

        return view(
            'admin.transactions.show',
            compact('transaction')
        );
    }
}
