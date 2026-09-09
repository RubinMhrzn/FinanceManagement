@extends('layouts.app')

@section('content')

    <div class="mx-auto max-w-7xl space-y-8 py-6">

        {{-- HEADER --}}
        <div>
            <p class="text-sm font-medium text-indigo-600">
                Manager Panel
            </p>

            <h1 class="mt-1 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                Financial Overview
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Monitor users, accounts, and transaction activity.
            </p>
        </div>


        {{-- SUMMARY CARDS --}}
        <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-4">

            {{-- Total Balance --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-medium text-slate-500">
                    Total Balance
                </p>

                <p class="mt-3 text-2xl font-bold text-slate-900">
                    NPR {{ number_format($totalBalance, 2) }}
                </p>

                <p class="mt-4 text-xs font-medium text-slate-500">
                    Across {{ $activeAccounts }} active accounts
                </p>
            </div>


            {{-- Total Income --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-medium text-slate-500">
                    Total Income
                </p>

                <p class="mt-3 text-2xl font-bold text-green-600">
                    NPR {{ number_format($totalIncome, 2) }}
                </p>

                <p class="mt-4 text-xs font-medium text-slate-500">
                    Approved income
                </p>
            </div>


            {{-- Total Expenses --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-medium text-slate-500">
                    Total Expenses
                </p>

                <p class="mt-3 text-2xl font-bold text-red-600">
                    NPR {{ number_format($totalExpenses, 2) }}
                </p>

                <p class="mt-4 text-xs font-medium text-slate-500">
                    Approved expenses
                </p>
            </div>


            {{-- Net Savings --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-medium text-slate-500">
                    Net Savings
                </p>

                <p class="mt-3 text-2xl font-bold text-indigo-600">
                    NPR {{ number_format($netSavings, 2) }}
                </p>

                <p
                    class="mt-4 text-xs font-medium
                {{ $savingsRate >= 0 ? 'text-green-600' : 'text-red-600' }}">
                    {{ number_format($savingsRate, 1) }}% savings rate
                </p>
            </div>

        </div>


        {{-- MIDDLE SECTION --}}
        <div class="grid gap-6 lg:grid-cols-3">

            {{-- Spending Overview --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm lg:col-span-2">

                <div>
                    <h2 class="font-semibold text-slate-900">
                        Spending Overview
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">
                        Approved income and expenses for {{ now()->year }}.
                    </p>
                </div>


                {{-- Chart --}}
                <div class="mt-8">

                    <div class="flex h-64 items-end justify-between gap-2 sm:gap-4">

                        @php
                            $maxValue = collect($monthlyData)
                                ->flatMap(fn($month) => [$month['income'], $month['expense']])
                                ->max();

                            $maxValue = $maxValue > 0 ? $maxValue : 1;
                        @endphp

                        @foreach ($monthlyData as $month)
                            @php
                                $incomeHeight = ($month['income'] / $maxValue) * 100;

                                $expenseHeight = ($month['expense'] / $maxValue) * 100;
                            @endphp

                            <div class="flex h-full flex-1 items-end justify-center gap-1">

                                {{-- Income --}}
                                <div class="w-1/2 rounded-t-lg bg-green-500/80 transition hover:bg-green-600"
                                    style="height: {{ $incomeHeight }}%"
                                    title="Income: NPR {{ number_format($month['income'], 2) }}">
                                </div>

                                {{-- Expense --}}
                                <div class="w-1/2 rounded-t-lg bg-red-500/80 transition hover:bg-red-600"
                                    style="height: {{ $expenseHeight }}%"
                                    title="Expense: NPR {{ number_format($month['expense'], 2) }}">
                                </div>

                            </div>
                        @endforeach

                    </div>


                    {{-- Months --}}
                    <div class="mt-4 flex justify-between text-xs text-slate-400">

                        @foreach (['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'] as $month)
                            <span>{{ $month }}</span>
                        @endforeach

                    </div>


                    {{-- Legend --}}
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


            {{-- Manager Actions --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                <h2 class="font-semibold text-slate-900">
                    Manager Actions
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Review and monitor financial activity.
                </p>


                <div class="mt-6 space-y-3">

                    {{-- Accounts --}}
                    <a href="{{ route('manager.accounts.index') }}"
                        class="flex items-center gap-4 rounded-xl border border-slate-200 p-4 transition hover:border-indigo-200 hover:bg-indigo-50">

                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-100 text-indigo-600">
                            →
                        </div>

                        <div>
                            <p class="text-sm font-semibold text-slate-800">
                                View All Accounts
                            </p>

                            <p class="text-xs text-slate-500">
                                Monitor user accounts
                            </p>
                        </div>

                    </a>


                    {{-- Pending Transactions --}}
                    <a href="{{ route('manager.transactions.index') }}"
                        class="flex items-center gap-4 rounded-xl border border-slate-200 p-4 transition hover:border-yellow-200 hover:bg-yellow-50">

                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-yellow-100 text-yellow-600">
                            !
                        </div>

                        <div>
                            <p class="text-sm font-semibold text-slate-800">
                                Pending Transactions
                            </p>

                            <p class="text-xs text-slate-500">
                                {{ $pendingTransactions }} waiting for review
                            </p>
                        </div>

                    </a>

                </div>

            </div>

        </div>


        {{-- ACCOUNT STATISTICS --}}
        <div class="grid gap-5 sm:grid-cols-3">

            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-sm text-slate-500">
                    Total Accounts
                </p>

                <p class="mt-2 text-2xl font-bold text-slate-900">
                    {{ $totalAccounts }}
                </p>
            </div>


            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-sm text-slate-500">
                    Active Accounts
                </p>

                <p class="mt-2 text-2xl font-bold text-green-600">
                    {{ $activeAccounts }}
                </p>
            </div>


            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-sm text-slate-500">
                    Inactive Accounts
                </p>

                <p class="mt-2 text-2xl font-bold text-red-600">
                    {{ $inactiveAccounts }}
                </p>
            </div>

        </div>


        {{-- PENDING TRANSACTIONS --}}
        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">

            <div class="flex items-center justify-between border-b border-slate-100 p-6">

                <div>
                    <h2 class="font-semibold text-slate-900">
                        Recent Pending Transactions
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">
                        Transactions waiting for manager approval.
                    </p>
                </div>

                <a href="{{ route('manager.transactions.index') }}"
                    class="text-sm font-semibold text-indigo-600 hover:text-indigo-700">
                    View all
                </a>

            </div>


            @if ($recentPendingTransactions->count() > 0)
                <div class="divide-y divide-slate-100">

                    @foreach ($recentPendingTransactions as $transaction)
                        <div class="flex flex-col gap-4 p-5 sm:flex-row sm:items-center sm:justify-between">

                            <div class="flex items-center gap-3">

                                <div
                                    class="flex h-10 w-10 items-center justify-center rounded-full
                                {{ $transaction->type === 'income' ? 'bg-green-50 text-green-600' : 'bg-red-50 text-red-600' }}">

                                    {{ $transaction->type === 'income' ? '↑' : '↓' }}

                                </div>

                                <div>

                                    <p class="text-sm font-semibold text-slate-800">
                                        {{ $transaction->description ?? 'Transaction' }}
                                    </p>

                                    <p class="text-xs text-slate-500">
                                        {{ $transaction->user->name ?? 'Unknown user' }}
                                        •
                                        {{ $transaction->account->name ?? 'Unknown account' }}
                                    </p>

                                    <p class="mt-1 text-xs text-slate-400">
                                        {{ $transaction->category->name ?? 'No category' }}
                                        •
                                        {{ $transaction->transaction_date->format('M d, Y') }}
                                    </p>

                                </div>

                            </div>


                            <div class="text-left sm:text-right">

                                <p
                                    class="text-sm font-semibold
                                {{ $transaction->type === 'income' ? 'text-green-600' : 'text-red-600' }}">

                                    {{ $transaction->type === 'income' ? '+' : '-' }}

                                    NPR {{ number_format($transaction->amount, 2) }}

                                </p>

                                <span class="text-xs font-medium text-yellow-600">
                                    Pending
                                </span>

                            </div>

                        </div>
                    @endforeach

                </div>
            @else
                <div class="p-6">
                    <p class="text-sm text-slate-500">
                        No pending transactions.
                    </p>
                </div>
            @endif

        </div>


        {{-- MONTHLY SUMMARY --}}
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

                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Month
                            </th>

                            <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Income
                            </th>

                            <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Expenses
                            </th>

                            <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">
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
