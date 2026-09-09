@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-7xl space-y-8 py-6">

        {{-- ============================================================
             HEADER
        ============================================================= --}}

        <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">

            <div>

                <p class="text-sm font-semibold text-indigo-600">
                    Personal Finance
                </p>

                <h1 class="mt-1 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                    My Transactions
                </h1>

                <p class="mt-2 max-w-2xl text-sm text-slate-500">
                    View and manage your income and expenses.
                    Transactions require manager approval before affecting your balance.
                </p>

            </div>


            {{-- Add Transaction --}}
            <a href="{{ route('transactions.create') }}"
                class="inline-flex w-fit items-center gap-2 rounded-xl
                       bg-indigo-600 px-5 py-3 text-sm font-semibold
                       text-white shadow-sm transition
                       hover:bg-indigo-700
                       focus:outline-none focus:ring-2
                       focus:ring-indigo-500 focus:ring-offset-2">

                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />

                </svg>

                Add Transaction

            </a>

        </div>


        {{-- ============================================================
             FILTERS
        ============================================================= --}}

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

            <div class="mb-4">

                <h2 class="font-semibold text-slate-900">
                    Filter Transactions
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Narrow down your transactions by type, status, account, or category.
                </p>

            </div>


            <form method="GET" action="{{ route('transactions.index') }}"
                class="grid gap-4 sm:grid-cols-2 lg:grid-cols-5">

                {{-- Type --}}
                <div>

                    <label for="type" class="mb-2 block text-sm font-medium text-slate-700">

                        Type

                    </label>

                    <select id="type" name="type"
                        class="w-full rounded-xl border border-slate-300
                               bg-white px-3 py-2.5 text-sm text-slate-700
                               focus:border-indigo-500 focus:outline-none
                               focus:ring-2 focus:ring-indigo-500">

                        <option value="">
                            All Types
                        </option>

                        <option value="income" {{ request('type') === 'income' ? 'selected' : '' }}>
                            Income
                        </option>

                        <option value="expense" {{ request('type') === 'expense' ? 'selected' : '' }}>
                            Expense
                        </option>

                    </select>

                </div>


                {{-- Status --}}
                <div>

                    <label for="status" class="mb-2 block text-sm font-medium text-slate-700">

                        Status

                    </label>

                    <select id="status" name="status"
                        class="w-full rounded-xl border border-slate-300
                               bg-white px-3 py-2.5 text-sm text-slate-700
                               focus:border-indigo-500 focus:outline-none
                               focus:ring-2 focus:ring-indigo-500">

                        <option value="">
                            All Statuses
                        </option>

                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>
                            Pending
                        </option>

                        <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>
                            Approved
                        </option>

                        <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>
                            Rejected
                        </option>

                    </select>

                </div>


                {{-- Account --}}
                <div>

                    <label for="account_id" class="mb-2 block text-sm font-medium text-slate-700">

                        Account

                    </label>

                    <select id="account_id" name="account_id"
                        class="w-full rounded-xl border border-slate-300
                               bg-white px-3 py-2.5 text-sm text-slate-700
                               focus:border-indigo-500 focus:outline-none
                               focus:ring-2 focus:ring-indigo-500">

                        <option value="">
                            All Accounts
                        </option>

                        @foreach ($accounts as $account)
                            <option value="{{ $account->id }}"
                                {{ (string) request('account_id') === (string) $account->id ? 'selected' : '' }}>

                                {{ $account->name }}

                            </option>
                        @endforeach
                    </select>

                </div>


                {{-- Category --}}
                <div>

                    <label for="category_id" class="mb-2 block text-sm font-medium text-slate-700">

                        Category

                    </label>

                    <select id="category_id" name="category_id"
                        class="w-full rounded-xl border border-slate-300
                               bg-white px-3 py-2.5 text-sm text-slate-700
                               focus:border-indigo-500 focus:outline-none
                               focus:ring-2 focus:ring-indigo-500">

                        <option value="">
                            All Categories
                        </option>

                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ (string) request('category_id') === (string) $category->id ? 'selected' : '' }}>

                                {{ $category->name }}
                                ({{ ucfirst($category->type) }})
                            </option>
                        @endforeach

                    </select>

                </div>


                {{-- Buttons --}}
                <div class="flex items-end gap-2">

                    <button type="submit"
                        class="flex-1 rounded-xl bg-slate-900
                               px-4 py-2.5 text-sm font-semibold
                               text-white transition hover:bg-slate-800">

                        Filter

                    </button>

                    <a href="{{ route('transactions.index') }}"
                        class="rounded-xl border border-slate-300
                               bg-white px-4 py-2.5 text-sm
                               font-semibold text-slate-600
                               transition hover:bg-slate-50">

                        Reset

                    </a>

                </div>

            </form>

        </div>


        {{-- ============================================================
             TRANSACTIONS CARD
        ============================================================= --}}

        <div class="overflow-hidden rounded-2xl border
                    border-slate-200 bg-white shadow-sm">

            {{-- Card Header --}}
            <div class="border-b border-slate-200 bg-slate-50 px-5 py-5 sm:px-6">

                <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">

                    <div>

                        <h2 class="font-semibold text-slate-900">
                            Transaction History
                        </h2>

                        <p class="mt-1 text-sm text-slate-500">
                            Your submitted income and expense transactions.
                        </p>

                    </div>

                    <span class="text-sm font-medium text-slate-500">

                        {{ $transactions->count() }}
                        {{ $transactions->count() === 1 ? 'transaction' : 'transactions' }}

                    </span>

                </div>

            </div>


            {{-- ========================================================
                 TRANSACTIONS
            ========================================================= --}}

            @forelse ($transactions as $transaction)
                {{-- ====================================================
                     DESKTOP TABLE
                ===================================================== --}}

                <div class="hidden overflow-x-auto md:block">

                    @if ($loop->first)
                        <table class="w-full text-left">

                            <thead class="border-b border-slate-200 bg-white">

                                <tr>

                                    <th
                                        class="px-6 py-4 text-xs font-semibold
                                               uppercase tracking-wide text-slate-500">

                                        Transaction

                                    </th>

                                    <th
                                        class="px-6 py-4 text-xs font-semibold
                                               uppercase tracking-wide text-slate-500">

                                        Account

                                    </th>

                                    <th
                                        class="px-6 py-4 text-xs font-semibold
                                               uppercase tracking-wide text-slate-500">

                                        Category

                                    </th>

                                    <th
                                        class="px-6 py-4 text-xs font-semibold
                                               uppercase tracking-wide text-slate-500">

                                        Date

                                    </th>

                                    <th
                                        class="px-6 py-4 text-xs font-semibold
                                               uppercase tracking-wide text-slate-500">

                                        Amount

                                    </th>

                                    <th
                                        class="px-6 py-4 text-xs font-semibold
                                               uppercase tracking-wide text-slate-500">

                                        Status

                                    </th>

                                    <th
                                        class="px-6 py-4 text-right text-xs
                                               font-semibold uppercase
                                               tracking-wide text-slate-500">

                                        Actions

                                    </th>

                                </tr>

                            </thead>

                            <tbody class="divide-y divide-slate-100">
                    @endif


                    {{-- =================================================
                         DESKTOP ROW
                    ================================================== --}}

                    <tr class="transition hover:bg-slate-50">

                        {{-- Transaction --}}
                        <td class="px-6 py-5">

                            <div class="flex items-center gap-3">

                                <div
                                    class="flex h-10 w-10 shrink-0
                                           items-center justify-center
                                           rounded-xl
                                           {{ $transaction->type === 'income' ? 'bg-emerald-50 text-emerald-600' : 'bg-red-50 text-red-600' }}">

                                    @if ($transaction->type === 'income')
                                        ↑
                                    @else
                                        ↓
                                    @endif

                                </div>

                                <div class="min-w-0">

                                    <p class="max-w-48 truncate font-semibold text-slate-800">

                                        {{ $transaction->description ?: 'No description' }}

                                    </p>

                                    <p class="mt-1 text-xs capitalize text-slate-500">

                                        {{ $transaction->type }}

                                    </p>

                                    <p class="mt-1 text-xs text-slate-400">

                                        {{ $transaction->id }}

                                    </p>

                                </div>

                            </div>

                        </td>


                        {{-- Account --}}
                        <td class="px-6 py-5">

                            <p class="text-sm font-medium text-slate-700">

                                {{ $transaction->account?->name ?? 'Unknown Account' }}

                            </p>

                            <p class="mt-1 text-xs text-slate-400">

                                {{ $transaction->account?->currency ?? 'NPR' }}

                            </p>

                        </td>


                        {{-- Category --}}
                        <td class="px-6 py-5">

                            <span
                                class="inline-flex rounded-full
                                       bg-slate-100 px-3 py-1
                                       text-xs font-medium capitalize
                                       text-slate-600">

                                {{ $transaction->category?->name ?? 'Uncategorized' }}

                            </span>

                        </td>


                        {{-- Date --}}
                        <td class="whitespace-nowrap px-6 py-5">

                            <p class="text-sm text-slate-700">

                                {{ $transaction->transaction_date?->format('M d, Y') ?? 'N/A' }}

                            </p>

                        </td>


                        {{-- Amount --}}
                        <td class="whitespace-nowrap px-6 py-5">

                            <p
                                class="font-bold
                                {{ $transaction->type === 'income' ? 'text-emerald-600' : 'text-red-600' }}">

                                {{ $transaction->type === 'income' ? '+' : '-' }}

                                {{ $transaction->account?->currency ?? 'NPR' }}

                                {{ number_format((float) $transaction->amount, 2) }}

                            </p>

                        </td>


                        {{-- Status --}}
                        <td class="px-6 py-5">

                            @if ($transaction->status === 'approved')
                                <span
                                    class="inline-flex rounded-full
                                           bg-emerald-50 px-3 py-1
                                           text-xs font-semibold
                                           text-emerald-700">

                                    Approved

                                </span>
                            @elseif ($transaction->status === 'rejected')
                                <span
                                    class="inline-flex rounded-full
                                           bg-red-50 px-3 py-1
                                           text-xs font-semibold
                                           text-red-700">

                                    Rejected

                                </span>
                            @else
                                <span
                                    class="inline-flex rounded-full
                                           bg-amber-50 px-3 py-1
                                           text-xs font-semibold
                                           text-amber-700">

                                    Pending

                                </span>
                            @endif

                        </td>


                        {{-- Actions --}}
                        <td class="px-6 py-5">

                            <div class="flex justify-end gap-2">

                                {{-- View --}}
                                <a href="{{ route('transactions.show', $transaction) }}"
                                    class="rounded-lg border border-slate-200
                                           px-3 py-2 text-xs font-semibold
                                           text-slate-600 transition
                                           hover:bg-slate-50">

                                    View

                                </a>


                                {{-- Edit --}}
                                @if ($transaction->status !== 'approved')
                                    <a href="{{ route('transactions.edit', $transaction) }}"
                                        class="rounded-lg border border-indigo-200
                                               px-3 py-2 text-xs font-semibold
                                               text-indigo-600 transition
                                               hover:bg-indigo-50">

                                        Edit

                                    </a>


                                    {{-- Delete --}}
                                    <form action="{{ route('transactions.destroy', $transaction) }}" method="POST">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                            onclick="return confirm('Are you sure you want to delete this transaction?')"
                                            class="rounded-lg border border-red-200
                                                   px-3 py-2 text-xs font-semibold
                                                   text-red-600 transition
                                                   hover:bg-red-50">

                                            Delete

                                        </button>

                                    </form>
                                @endif

                            </div>

                        </td>

                    </tr>


                    @if ($loop->last)
                        </tbody>

                        </table>
                    @endif

                </div>


                {{-- ====================================================
                     MOBILE CARD
                ===================================================== --}}

                <div class="border-b border-slate-100 p-5 last:border-b-0 md:hidden">

                    {{-- Top --}}
                    <div class="flex items-start justify-between gap-4">

                        <div class="flex min-w-0 items-center gap-3">

                            <div
                                class="flex h-11 w-11 shrink-0
                                       items-center justify-center
                                       rounded-xl
                                       {{ $transaction->type === 'income' ? 'bg-emerald-50 text-emerald-600' : 'bg-red-50 text-red-600' }}">

                                <span class="text-lg">

                                    {{ $transaction->type === 'income' ? '↑' : '↓' }}

                                </span>

                            </div>

                            <div class="min-w-0">

                                <p class="truncate font-semibold text-slate-800">

                                    {{ $transaction->description ?: 'No description' }}

                                </p>

                                <p class="mt-1 text-xs capitalize text-slate-500">

                                    {{ $transaction->type }}

                                </p>

                                <p class="mt-1 text-xs text-slate-400">

                                    Transaction #{{ $transaction->id }}

                                </p>

                            </div>

                        </div>


                        {{-- Amount --}}
                        <div class="shrink-0 text-right">

                            <p
                                class="font-bold
                                {{ $transaction->type === 'income' ? 'text-emerald-600' : 'text-red-600' }}">

                                {{ $transaction->type === 'income' ? '+' : '-' }}

                                {{ $transaction->account?->currency ?? 'NPR' }}

                                {{ number_format((float) $transaction->amount, 2) }}

                            </p>


                            @if ($transaction->status === 'approved')
                                <span
                                    class="mt-1 inline-flex rounded-full
                                           bg-emerald-50 px-2 py-0.5
                                           text-xs font-medium text-emerald-700">

                                    Approved

                                </span>
                            @elseif ($transaction->status === 'rejected')
                                <span
                                    class="mt-1 inline-flex rounded-full
                                           bg-red-50 px-2 py-0.5
                                           text-xs font-medium text-red-700">

                                    Rejected

                                </span>
                            @else
                                <span
                                    class="mt-1 inline-flex rounded-full
                                           bg-amber-50 px-2 py-0.5
                                           text-xs font-medium text-amber-700">

                                    Pending

                                </span>
                            @endif

                        </div>

                    </div>


                    {{-- Details --}}
                    <div class="mt-5 rounded-xl bg-slate-50 p-4">

                        <div class="space-y-3 text-sm">

                            {{-- Account --}}
                            <div class="flex items-center justify-between gap-4">

                                <span class="text-slate-500">
                                    Account
                                </span>

                                <span class="truncate font-medium text-slate-700">

                                    {{ $transaction->account?->name ?? 'Unknown Account' }}

                                </span>

                            </div>


                            {{-- Category --}}
                            <div class="flex items-center justify-between gap-4">

                                <span class="text-slate-500">
                                    Category
                                </span>

                                <span class="truncate font-medium text-slate-700">

                                    {{ $transaction->category?->name ?? 'Uncategorized' }}

                                </span>

                            </div>


                            {{-- Date --}}
                            <div class="flex items-center justify-between gap-4">

                                <span class="text-slate-500">
                                    Date
                                </span>

                                <span class="font-medium text-slate-700">

                                    {{ $transaction->transaction_date?->format('M d, Y') ?? 'N/A' }}

                                </span>

                            </div>


                            {{-- Status --}}
                            <div class="flex items-center justify-between gap-4">

                                <span class="text-slate-500">
                                    Status
                                </span>

                                <span class="font-medium capitalize text-slate-700">

                                    {{ $transaction->status }}

                                </span>

                            </div>

                        </div>

                    </div>


                    {{-- Actions --}}
                    <div class="mt-5 flex flex-wrap gap-2">

                        {{-- View --}}
                        <a href="{{ route('transactions.show', $transaction) }}"
                            class="flex-1 rounded-xl border border-slate-200
                                   px-4 py-2.5 text-center text-sm
                                   font-semibold text-slate-600
                                   transition hover:bg-slate-50">

                            View

                        </a>


                        {{-- Edit --}}
                        @if ($transaction->status !== 'approved')
                            <a href="{{ route('transactions.edit', $transaction) }}"
                                class="flex-1 rounded-xl border border-indigo-200
                                       px-4 py-2.5 text-center text-sm
                                       font-semibold text-indigo-600
                                       transition hover:bg-indigo-50">

                                Edit

                            </a>


                            {{-- Delete --}}
                            <form action="{{ route('transactions.destroy', $transaction) }}" method="POST"
                                class="flex-1">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                    onclick="return confirm('Are you sure you want to delete this transaction?')"
                                    class="w-full rounded-xl border border-red-200
                                           px-4 py-2.5 text-sm font-semibold
                                           text-red-600 transition
                                           hover:bg-red-50">

                                    Delete

                                </button>

                            </form>
                        @endif

                    </div>

                </div>

            @empty

                {{-- ====================================================
                     EMPTY STATE
                ===================================================== --}}

                <div class="px-6 py-20 text-center">

                    <div
                        class="mx-auto flex h-16 w-16 items-center
                               justify-center rounded-2xl
                               bg-indigo-50 text-indigo-600">

                        <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l2 2 4-4m5-2a9 9 0 11-18 0
                                                       9 9 0 0118 0z" />

                        </svg>

                    </div>


                    <h3 class="mt-5 text-lg font-semibold text-slate-900">

                        No transactions found

                    </h3>


                    <p class="mx-auto mt-2 max-w-md text-sm text-slate-500">

                        You haven't created any transactions yet,
                        or no transactions match your selected filters.

                    </p>


                    <a href="{{ route('transactions.create') }}"
                        class="mt-6 inline-flex items-center gap-2
                               rounded-xl bg-indigo-600 px-4 py-2.5
                               text-sm font-semibold text-white
                               transition hover:bg-indigo-700">

                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />

                        </svg>

                        Add Your First Transaction

                    </a>

                </div>
            @endforelse

        </div>

    </div>
@endsection
