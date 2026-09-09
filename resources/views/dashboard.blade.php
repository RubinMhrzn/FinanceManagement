@extends('layouts.app')

@section('content')

    <div class="mx-auto max-w-7xl space-y-8 py-6">

        {{-- ================= HEADER ================= --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <p class="text-sm font-medium text-indigo-600">
                    Welcome back 👋
                </p>

                <h1 class="mt-1 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                    {{ auth()->user()->name }}
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Here's what's happening with your finances.
                </p>
            </div>

            <div class="flex gap-3">

                {{-- Add Transaction --}}
                <a href="{{ route('transactions.create') }}"
                    class="inline-flex items-center justify-center rounded-xl
                bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white
                shadow-sm transition hover:bg-indigo-700">

                    <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>

                    Add Transaction

                </a>

            </div>

        </div>


        {{-- ================= SUMMARY CARDS ================= --}}
        <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-4">

            {{-- Total Balance --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                <div class="flex items-start justify-between">

                    <div>
                        <p class="text-sm font-medium text-slate-500">
                            Total Balance
                        </p>

                        <p class="mt-3 text-2xl font-bold text-slate-900">
                            NPR {{ number_format($totalBalance, 2) }}
                        </p>
                    </div>

                    <div
                        class="flex h-11 w-11 items-center justify-center
                    rounded-xl bg-indigo-50 text-indigo-600">

                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3
                                    3 1.343 3 3-1.343 3-3 3m0-14V5m0 14v2
                                    m9-9a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>

                    </div>

                </div>

                <p class="mt-4 text-xs font-medium text-slate-500">
                    Across {{ $accounts->count() }} active
                    {{ $accounts->count() === 1 ? 'account' : 'accounts' }}
                </p>

            </div>


            {{-- Income --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                <div class="flex items-start justify-between">

                    <div>

                        <p class="text-sm font-medium text-slate-500">
                            Total Income
                        </p>

                        <p class="mt-3 text-2xl font-bold text-slate-900">
                            NPR {{ number_format($totalIncome, 2) }}
                        </p>

                    </div>

                    <div
                        class="flex h-11 w-11 items-center justify-center
                    rounded-xl bg-green-50 text-green-600">

                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 19V5m0 0l-6 6m6-6l6 6" />
                        </svg>

                    </div>

                </div>

                <p class="mt-4 text-xs font-medium text-green-600">
                    Approved income
                </p>

            </div>


            {{-- Expenses --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                <div class="flex items-start justify-between">

                    <div>

                        <p class="text-sm font-medium text-slate-500">
                            Total Expenses
                        </p>

                        <p class="mt-3 text-2xl font-bold text-slate-900">
                            NPR {{ number_format($totalExpenses, 2) }}
                        </p>

                    </div>

                    <div
                        class="flex h-11 w-11 items-center justify-center
                    rounded-xl bg-red-50 text-red-600">

                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 5v14m0 0l6-6m-6 6l-6-6" />
                        </svg>

                    </div>

                </div>

                <p class="mt-4 text-xs font-medium text-red-600">
                    Approved expenses
                </p>

            </div>


            {{-- Savings --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                <div class="flex items-start justify-between">

                    <div>

                        <p class="text-sm font-medium text-slate-500">
                            Savings
                        </p>

                        <p class="mt-3 text-2xl font-bold text-slate-900">
                            NPR {{ number_format($savings, 2) }}
                        </p>

                    </div>

                    <div
                        class="flex h-11 w-11 items-center justify-center
                    rounded-xl bg-purple-50 text-purple-600">

                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 1.343-3 3
                                    0 1.657 1.343 3 3 3
                                    1.657 0 3-1.343 3-3
                                    0-1.657-1.343-3-3-3zm0 0V5
                                    m0 9v5" />
                        </svg>

                    </div>

                </div>

                <p
                    class="mt-4 text-xs font-medium
                {{ $savingsRate >= 0 ? 'text-green-600' : 'text-red-600' }}">

                    {{ number_format($savingsRate, 1) }}% savings rate

                </p>

            </div>

        </div>


        {{-- ================= MIDDLE SECTION ================= --}}
        <div class="grid gap-6 lg:grid-cols-3">

            {{-- Spending Overview --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm lg:col-span-2">

                <div class="flex items-center justify-between">

                    <div>

                        <h2 class="font-semibold text-slate-900">
                            Spending Overview
                        </h2>

                        <p class="mt-1 text-sm text-slate-500">
                            Your income and expenses for {{ now()->year }}.
                        </p>

                    </div>

                </div>


                {{-- Chart --}}
                <div class="mt-8">

                    <div class="flex h-64 items-end justify-between gap-2 sm:gap-4">

                        @foreach ($monthlyData as $month => $data)
                            @php
                                $income = $data['income'];
                                $expense = $data['expense'];

                                $maxValue = max($income, $expense, 1);

                                $incomeHeight = ($income / $maxValue) * 100;
                                $expenseHeight = ($expense / $maxValue) * 100;
                            @endphp

                            <div class="flex h-full flex-1 items-end justify-center gap-1">

                                {{-- Income --}}
                                <div class="w-1/2 rounded-t-lg bg-green-500/80 transition hover:bg-green-600"
                                    style="height: {{ $incomeHeight }}%"
                                    title="Income: NPR {{ number_format($income, 2) }}">
                                </div>

                                {{-- Expense --}}
                                <div class="w-1/2 rounded-t-lg bg-red-500/80 transition hover:bg-red-600"
                                    style="height: {{ $expenseHeight }}%"
                                    title="Expense: NPR {{ number_format($expense, 2) }}">
                                </div>

                            </div>
                        @endforeach

                    </div>


                    {{-- Months --}}
                    <div class="mt-4 flex justify-between text-xs text-slate-400">

                        @foreach ([
            1 => 'Jan',
            2 => 'Feb',
            3 => 'Mar',
            4 => 'Apr',
            5 => 'May',
            6 => 'Jun',
            7 => 'Jul',
            8 => 'Aug',
            9 => 'Sep',
            10 => 'Oct',
            11 => 'Nov',
            12 => 'Dec',
        ] as $month => $name)
                            <span>
                                {{ $name }}
                            </span>
                        @endforeach

                    </div>


                    {{-- Chart Legend --}}
                    <div class="mt-6 flex justify-center gap-6 text-sm">

                        <div class="flex items-center gap-2">
                            <span class="h-3 w-3 rounded-full bg-green-500"></span>

                            <span class="text-slate-500">
                                Income
                            </span>
                        </div>

                        <div class="flex items-center gap-2">
                            <span class="h-3 w-3 rounded-full bg-red-500"></span>

                            <span class="text-slate-500">
                                Expenses
                            </span>
                        </div>

                    </div>

                </div>

            </div>


            {{-- Quick Actions --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                <h2 class="font-semibold text-slate-900">
                    Quick Actions
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Manage your finances quickly.
                </p>


                <div class="mt-6 space-y-3">

                    {{-- Add Transaction --}}
                    <a href="{{ route('transactions.create') }}"
                        class="flex items-center gap-4 rounded-xl border border-slate-200
                    p-4 transition hover:border-indigo-200 hover:bg-indigo-50">

                        <div
                            class="flex h-10 w-10 items-center justify-center
                        rounded-lg bg-indigo-100 text-indigo-600">

                            +

                        </div>

                        <div>

                            <p class="text-sm font-semibold text-slate-800">
                                Add Transaction
                            </p>

                            <p class="text-xs text-slate-500">
                                Record income or expense
                            </p>

                        </div>

                    </a>


                    {{-- Add Account --}}
                    <a href="{{ route('accounts.create') }}"
                        class="flex items-center gap-4 rounded-xl border border-slate-200
                    p-4 transition hover:border-green-200 hover:bg-green-50">

                        <div
                            class="flex h-10 w-10 items-center justify-center
                        rounded-lg bg-green-100 text-green-600">

                            +

                        </div>

                        <div>

                            <p class="text-sm font-semibold text-slate-800">
                                Add Account
                            </p>

                            <p class="text-xs text-slate-500">
                                Add a bank or wallet
                            </p>

                        </div>

                    </a>


                    {{-- Add Category --}}
                    <a href="{{ route('categories.create') }}"
                        class="flex items-center gap-4 rounded-xl border border-slate-200
                    p-4 transition hover:border-purple-200 hover:bg-purple-50">

                        <div
                            class="flex h-10 w-10 items-center justify-center
                        rounded-lg bg-purple-100 text-purple-600">

                            +

                        </div>

                        <div>

                            <p class="text-sm font-semibold text-slate-800">
                                Add Category
                            </p>

                            <p class="text-xs text-slate-500">
                                Organize your transactions
                            </p>

                        </div>

                    </a>

                </div>

            </div>

        </div>


        {{-- ================= BOTTOM SECTION ================= --}}
        <div class="grid gap-6 lg:grid-cols-3">

            {{-- Accounts --}}
            <div class="rounded-2xl border border-slate-200 bg-white shadow-sm lg:col-span-1">

                <div class="flex items-center justify-between border-b border-slate-100 p-6">

                    <div>

                        <h2 class="font-semibold text-slate-900">
                            My Accounts
                        </h2>

                        <p class="mt-1 text-sm text-slate-500">
                            Your active accounts
                        </p>

                    </div>

                    {{-- View All Accounts --}}
                    <a href="{{ route('accounts.index') }}"
                        class="text-sm font-semibold text-indigo-600 hover:text-indigo-700">

                        View all

                    </a>

                </div>


                @if ($accounts->count() > 0)
                    <div class="divide-y divide-slate-100">

                        @foreach ($accounts as $account)
                            <div class="flex items-center justify-between p-5">

                                <div class="flex items-center gap-3">

                                    <div
                                        class="flex h-10 w-10 items-center justify-center
                                    rounded-lg bg-indigo-50 text-indigo-600">

                                        {{ strtoupper(substr($account->name, 0, 1)) }}

                                    </div>

                                    <div>

                                        <p class="text-sm font-semibold text-slate-800">
                                            {{ $account->name }}
                                        </p>

                                        <p class="text-xs text-slate-500">
                                            {{ ucfirst($account->type ?? 'Account') }}
                                        </p>

                                    </div>

                                </div>

                                <p
                                    class="text-sm font-bold
                                {{ $account->balance >= 0 ? 'text-slate-900' : 'text-red-600' }}">

                                    NPR {{ number_format($account->balance, 2) }}

                                </p>

                            </div>
                        @endforeach

                    </div>
                @else
                    <div class="p-6">

                        <p class="text-sm text-slate-500">
                            You don't have any active accounts yet.
                        </p>

                        <a href="{{ route('accounts.create') }}"
                            class="mt-3 inline-block text-sm font-semibold text-indigo-600 hover:text-indigo-700">

                            Create an account →

                        </a>

                    </div>
                @endif

            </div>


            {{-- Recent Transactions --}}
            <div class="rounded-2xl border border-slate-200 bg-white shadow-sm lg:col-span-2">

                <div class="flex items-center justify-between border-b border-slate-100 p-6">

                    <div>

                        <h2 class="font-semibold text-slate-900">
                            Recent Transactions
                        </h2>

                        <p class="mt-1 text-sm text-slate-500">
                            Your latest financial activity
                        </p>

                    </div>

                    <div class="flex items-center gap-3">

                        @if ($pendingTransactions > 0)
                            <span
                                class="rounded-full bg-yellow-50 px-3 py-1
                            text-xs font-medium text-yellow-700">

                                {{ $pendingTransactions }}
                                pending

                            </span>
                        @endif

                        {{-- View All Transactions --}}
                        <a href="{{ route('transactions.index') }}"
                            class="hidden text-sm font-semibold text-indigo-600 hover:text-indigo-700 sm:block">

                            View all

                        </a>

                    </div>

                </div>


                @if ($recentTransactions->count() > 0)
                    <div class="divide-y divide-slate-100">

                        @foreach ($recentTransactions as $transaction)
                            <div class="flex items-center justify-between gap-4 p-5">

                                <div class="flex min-w-0 items-center gap-3">

                                    {{-- Transaction Icon --}}
                                    <div
                                        class="flex h-10 w-10 shrink-0 items-center
                                    justify-center rounded-full
                                    {{ $transaction->type === 'income' ? 'bg-green-50 text-green-600' : 'bg-red-50 text-red-600' }}">

                                        {{ $transaction->type === 'income' ? '↑' : '↓' }}

                                    </div>


                                    <div class="min-w-0">

                                        <p class="truncate text-sm font-semibold text-slate-800">

                                            {{ $transaction->description ?? 'Transaction' }}

                                        </p>


                                        <p class="text-xs text-slate-500">

                                            {{ $transaction->account->name ?? 'Unknown account' }}

                                            @if ($transaction->category)
                                                • {{ $transaction->category->name }}
                                            @endif

                                        </p>


                                        <p class="mt-1 text-xs text-slate-400">

                                            {{ \Carbon\Carbon::parse($transaction->transaction_date)->format('M d, Y') }}

                                        </p>

                                    </div>

                                </div>


                                <div class="shrink-0 text-right">

                                    <p
                                        class="text-sm font-semibold
                                    {{ $transaction->type === 'income' ? 'text-green-600' : 'text-red-600' }}">

                                        {{ $transaction->type === 'income' ? '+' : '-' }}

                                        NPR {{ number_format($transaction->amount, 2) }}

                                    </p>


                                    <span
                                        class="text-xs
                                    {{ $transaction->status === 'approved'
                                        ? 'text-green-600'
                                        : ($transaction->status === 'pending'
                                            ? 'text-yellow-600'
                                            : 'text-red-600') }}">

                                        {{ ucfirst($transaction->status) }}

                                    </span>

                                </div>

                            </div>
                        @endforeach

                    </div>
                @else
                    <div class="p-6">

                        <p class="text-sm text-slate-500">
                            No transactions found.
                        </p>

                        <a href="{{ route('transactions.create') }}"
                            class="mt-3 inline-block text-sm font-semibold text-indigo-600 hover:text-indigo-700">

                            Add your first transaction →

                        </a>

                    </div>
                @endif

            </div>

        </div>


        {{-- ================= MONTHLY SUMMARY ================= --}}
        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-100 p-6">

                <h2 class="font-semibold text-slate-900">
                    Monthly Summary
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Income and expenses for {{ now()->year }}.
                </p>

            </div>


            <div class="overflow-x-auto">

                <table class="w-full">

                    <thead class="bg-slate-50">

                        <tr>

                            <th
                                class="px-6 py-3 text-left text-xs font-semibold
                            uppercase tracking-wider text-slate-500">

                                Month

                            </th>

                            <th
                                class="px-6 py-3 text-right text-xs font-semibold
                            uppercase tracking-wider text-slate-500">

                                Income

                            </th>

                            <th
                                class="px-6 py-3 text-right text-xs font-semibold
                            uppercase tracking-wider text-slate-500">

                                Expenses

                            </th>

                            <th
                                class="px-6 py-3 text-right text-xs font-semibold
                            uppercase tracking-wider text-slate-500">

                                Savings

                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-slate-100">

                        @foreach ($monthlyData as $month => $data)
                            @php
                                $monthSavings = $data['income'] - $data['expense'];
                            @endphp

                            <tr class="hover:bg-slate-50">

                                <td class="px-6 py-4 text-sm font-medium text-slate-800">

                                    {{ \Carbon\Carbon::create()->month($month)->format('F') }}

                                </td>


                                <td class="px-6 py-4 text-right text-sm font-medium text-green-600">

                                    NPR {{ number_format($data['income'], 2) }}

                                </td>


                                <td class="px-6 py-4 text-right text-sm font-medium text-red-600">

                                    NPR {{ number_format($data['expense'], 2) }}

                                </td>


                                <td
                                    class="px-6 py-4 text-right text-sm font-medium
                                {{ $monthSavings >= 0 ? 'text-indigo-600' : 'text-red-600' }}">

                                    NPR {{ number_format($monthSavings, 2) }}

                                </td>

                            </tr>
                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    </div>

@endsection
