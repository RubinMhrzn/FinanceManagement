<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | User Accounts
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $accounts = Account::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view(
            'accounts.index',
            compact('accounts')
        );
    }

    public function create()
    {
        return view('accounts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',

            'type' => [
                'required',
                'in:bank,cash,wallet,credit_card',
            ],

            'balance' => [
                'required',
                'numeric',
                'min:0',
            ],

            'currency' => [
                'required',
                'string',
                'size:3',
            ],

            'is_active' => 'nullable|boolean',
        ]);

        $validated['user_id'] = Auth::id();

        $validated['currency'] = strtoupper(
            $validated['currency']
        );

        $validated['is_active'] = $request->boolean('is_active');

        Account::create($validated);

        return redirect()
            ->route('accounts.index')
            ->with('success', 'Account created successfully.');
    }

    public function show(Account $account)
    {
        $this->authorizeAccount($account);

        $account->load([
            'transactions' => function ($query) {
                $query
                    ->latest('transaction_date')
                    ->latest('id');
            },
            'transactions.category',
        ]);

        return view(
            'accounts.show',
            compact('account')
        );
    }

    public function edit(Account $account)
    {
        $this->authorizeAccount($account);

        return view(
            'accounts.edit',
            compact('account')
        );
    }

    public function update(
        Request $request,
        Account $account
    ) {
        $this->authorizeAccount($account);

        $validated = $request->validate([
            'name' => 'required|string|max:255',

            'type' => [
                'required',
                'in:bank,cash,wallet,credit_card',
            ],

            'balance' => [
                'required',
                'numeric',
                'min:0',
            ],

            'currency' => [
                'required',
                'string',
                'size:3',
            ],

            'is_active' => 'nullable|boolean',
        ]);

        $validated['currency'] = strtoupper(
            $validated['currency']
        );

        $validated['is_active'] = $request->boolean('is_active');

        $account->update($validated);

        return redirect()
            ->route('accounts.index')
            ->with('success', 'Account updated successfully.');
    }

    public function destroy(Account $account)
    {
        $this->authorizeAccount($account);

        if ($account->transactions()->exists()) {
            return back()->with(
                'error',
                'This account cannot be deleted because it has transactions.'
            );
        }

        $account->delete();

        return redirect()
            ->route('accounts.index')
            ->with('success', 'Account deleted successfully.');
    }

    /*
    |--------------------------------------------------------------------------
    | Authorization
    |--------------------------------------------------------------------------
    */

    private function authorizeAccount(Account $account)
    {
        if ($account->user_id !== Auth::id()) {
            abort(403);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN - All Accounts
    |--------------------------------------------------------------------------
    */

    public function adminIndex()
    {
        $accounts = Account::with('user')
            ->latest()
            ->get();

        return view(
            'admin.accounts.index',
            compact('accounts')
        );
    }
}
