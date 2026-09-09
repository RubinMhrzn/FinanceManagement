@extends('layouts.app')

@section('content')

    <div class="mx-auto max-w-7xl space-y-8 py-6">


        {{-- ============================================================
             HEADER
        ============================================================= --}}

        <div>

            <p class="text-sm font-semibold text-indigo-600">
                Administration
            </p>

            <h1 class="mt-1 text-3xl font-bold tracking-tight text-slate-900">
                Admin Dashboard
            </h1>

            <p class="mt-2 text-sm text-slate-500">
                Monitor users, accounts and financial activity across the system.
            </p>

        </div>



        {{-- ============================================================
             STATISTICS
        ============================================================= --}}

        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">


            {{-- Total Users --}}

            <div class="rounded-2xl border border-slate-200
                       bg-white p-6 shadow-sm">

                <p class="text-sm font-medium text-slate-500">
                    Total Users
                </p>

                <p class="mt-2 text-3xl font-bold text-slate-900">
                    {{ number_format($totalUsers) }}
                </p>

                <p class="mt-4 text-xs text-slate-500">

                    {{ $totalAdmins }} admin ·
                    {{ $totalManagers }} manager ·
                    {{ $totalRegularUsers }} users

                </p>

            </div>



            {{-- Total Accounts --}}

            <div class="rounded-2xl border border-slate-200
                       bg-white p-6 shadow-sm">

                <p class="text-sm font-medium text-slate-500">
                    Total Accounts
                </p>

                <p class="mt-2 text-3xl font-bold text-slate-900">
                    {{ number_format($totalAccounts) }}
                </p>

                <p class="mt-4 text-xs text-slate-500">

                    {{ $activeAccounts }} active accounts

                </p>

            </div>



            {{-- Transactions --}}

            <div class="rounded-2xl border border-slate-200
                       bg-white p-6 shadow-sm">

                <p class="text-sm font-medium text-slate-500">
                    Transactions
                </p>

                <p class="mt-2 text-3xl font-bold text-slate-900">
                    {{ number_format($totalTransactions) }}
                </p>

                <p class="mt-4 text-xs text-slate-500">

                    {{ $approvedTransactions }} approved

                </p>

            </div>



            {{-- Pending --}}

            <div class="rounded-2xl border border-amber-200
                       bg-amber-50 p-6 shadow-sm">

                <p class="text-sm font-medium text-amber-700">
                    Pending Transactions
                </p>

                <p class="mt-2 text-3xl font-bold text-amber-900">
                    {{ number_format($pendingTransactions) }}
                </p>

                <p class="mt-4 text-xs text-amber-700">
                    Awaiting manager review
                </p>

            </div>

        </div>



        {{-- ============================================================
             FINANCIAL OVERVIEW
        ============================================================= --}}

        <div class="grid gap-5 md:grid-cols-3">


            {{-- Balance --}}

            <div class="rounded-2xl border border-slate-200
                       bg-white p-6 shadow-sm">

                <p class="text-sm font-medium text-slate-500">
                    Total Account Balance
                </p>

                <p class="mt-2 text-2xl font-bold text-slate-900">

                    NPR {{ number_format($totalBalance, 2) }}

                </p>

                <p class="mt-2 text-xs text-slate-500">
                    Across all user accounts
                </p>

            </div>



            {{-- Income --}}

            <div class="rounded-2xl border border-slate-200
                       bg-white p-6 shadow-sm">

                <p class="text-sm font-medium text-slate-500">
                    Approved Income
                </p>

                <p class="mt-2 text-2xl font-bold text-green-600">

                    NPR {{ number_format($totalIncome, 2) }}

                </p>

                <p class="mt-2 text-xs text-slate-500">
                    System-wide approved income
                </p>

            </div>



            {{-- Expenses --}}

            <div class="rounded-2xl border border-slate-200
                       bg-white p-6 shadow-sm">

                <p class="text-sm font-medium text-slate-500">
                    Approved Expenses
                </p>

                <p class="mt-2 text-2xl font-bold text-red-600">

                    NPR {{ number_format($totalExpenses, 2) }}

                </p>

                <p class="mt-2 text-xs text-slate-500">
                    System-wide approved expenses
                </p>

            </div>

        </div>



        {{-- ============================================================
             SECONDARY STATISTICS
        ============================================================= --}}

        <div class="grid gap-5 sm:grid-cols-3">


            {{-- Net Savings --}}

            <div class="rounded-2xl border border-slate-200
                       bg-white p-5">

                <p class="text-sm text-slate-500">
                    Net Savings
                </p>

                <p class="mt-2 text-xl font-bold text-slate-900">

                    NPR {{ number_format($netSavings, 2) }}

                </p>

            </div>



            {{-- Rejected --}}

            <div class="rounded-2xl border border-slate-200
                       bg-white p-5">

                <p class="text-sm text-slate-500">
                    Rejected Transactions
                </p>

                <p class="mt-2 text-xl font-bold text-red-600">

                    {{ number_format($rejectedTransactions) }}

                </p>

            </div>



            {{-- Active Accounts --}}

            <div class="rounded-2xl border border-slate-200
                       bg-white p-5">

                <p class="text-sm text-slate-500">
                    Active Accounts
                </p>

                <p class="mt-2 text-xl font-bold text-slate-900">

                    {{ number_format($activeAccounts) }}

                </p>

            </div>

        </div>



        {{-- ============================================================
             RECENT USERS + ROLES
        ============================================================= --}}

        <div class="grid gap-6 lg:grid-cols-2">


            {{-- Recent Users --}}

            <div class="rounded-2xl border border-slate-200
                       bg-white shadow-sm">

                <div class="flex items-center justify-between
                           border-b border-slate-200 p-6">

                    <div>

                        <h2 class="font-semibold text-slate-900">
                            Recent Users
                        </h2>

                        <p class="mt-1 text-sm text-slate-500">
                            Recently registered users
                        </p>

                    </div>


                    <a href="{{ route('admin.users.index') }}"
                        class="text-sm font-medium text-indigo-600
                               hover:text-indigo-800">

                        View All

                    </a>

                </div>


                <div class="divide-y divide-slate-100">

                    @forelse ($recentUsers as $user)
                        <div class="flex items-center justify-between p-5">

                            <div class="flex items-center gap-3">

                                <div
                                    class="flex h-10 w-10 items-center
                                           justify-center rounded-full
                                           bg-indigo-100 font-semibold
                                           text-indigo-700">

                                    {{ strtoupper(substr($user->name, 0, 1)) }}

                                </div>


                                <div>

                                    <p class="font-medium text-slate-900">
                                        {{ $user->name }}
                                    </p>

                                    <p class="text-xs text-slate-500">
                                        {{ $user->email }}
                                    </p>

                                </div>

                            </div>


                            <span
                                class="rounded-full bg-slate-100
                                       px-3 py-1 text-xs font-medium
                                       capitalize text-slate-600">

                                {{ $user->role?->name ?? 'user' }}

                            </span>

                        </div>

                    @empty

                        <div class="p-6 text-center text-sm text-slate-500">
                            No users found.
                        </div>
                    @endforelse

                </div>

            </div>



            {{-- Role Distribution --}}

            <div class="rounded-2xl border border-slate-200
                       bg-white shadow-sm">

                <div class="border-b border-slate-200 p-6">

                    <h2 class="font-semibold text-slate-900">
                        Role Distribution
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">
                        Users grouped by role
                    </p>

                </div>


                <div class="space-y-5 p-6">

                    @forelse ($roles as $role)
                        @php

                            $percentage = $totalUsers > 0 ? ($role->users_count / $totalUsers) * 100 : 0;

                        @endphp


                        <div>

                            <div class="mb-2 flex items-center justify-between">

                                <span
                                    class="text-sm font-medium
                                           capitalize text-slate-700">

                                    {{ $role->name }}

                                </span>

                                <span class="text-sm font-semibold text-slate-900">

                                    {{ $role->users_count }}

                                </span>

                            </div>


                            <div
                                class="h-2 overflow-hidden rounded-full
                                       bg-slate-100">

                                <div class="h-full rounded-full bg-indigo-500" style="width: {{ $percentage }}%">

                                </div>

                            </div>

                        </div>

                    @empty

                        <p class="text-sm text-slate-500">
                            No roles found.
                        </p>
                    @endforelse

                </div>

            </div>

        </div>



        {{-- ============================================================
             PENDING TRANSACTIONS
        ============================================================= --}}

        <div class="rounded-2xl border border-slate-200
                   bg-white shadow-sm">

            <div class="flex items-center justify-between
                       border-b border-slate-200 p-6">

                <div>

                    <h2 class="font-semibold text-slate-900">
                        Pending Transactions
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">
                        Transactions waiting for manager approval
                    </p>

                </div>


                @if ($pendingTransactions > 0)
                    <span
                        class="rounded-full bg-amber-100
                               px-3 py-1 text-xs font-semibold
                               text-amber-700">

                        {{ $pendingTransactions }} Pending

                    </span>
                @endif

            </div>


            @if ($recentPendingTransactions->count())
                <div class="overflow-x-auto">

                    <table class="min-w-full divide-y divide-slate-200">

                        <thead class="bg-slate-50">

                            <tr>

                                <th
                                    class="px-6 py-3 text-left text-xs
                                           font-semibold uppercase
                                           tracking-wider text-slate-500">

                                    User

                                </th>

                                <th
                                    class="px-6 py-3 text-left text-xs
                                           font-semibold uppercase
                                           tracking-wider text-slate-500">

                                    Account

                                </th>

                                <th
                                    class="px-6 py-3 text-left text-xs
                                           font-semibold uppercase
                                           tracking-wider text-slate-500">

                                    Category

                                </th>

                                <th
                                    class="px-6 py-3 text-left text-xs
                                           font-semibold uppercase
                                           tracking-wider text-slate-500">

                                    Amount

                                </th>

                                <th
                                    class="px-6 py-3 text-left text-xs
                                           font-semibold uppercase
                                           tracking-wider text-slate-500">

                                    Date

                                </th>

                            </tr>

                        </thead>


                        <tbody class="divide-y divide-slate-100 bg-white">

                            @foreach ($recentPendingTransactions as $transaction)
                                <tr class="hover:bg-slate-50">


                                    <td class="whitespace-nowrap px-6 py-4">

                                        <p class="text-sm font-medium text-slate-900">

                                            {{ $transaction->user?->name ?? 'Unknown' }}

                                        </p>

                                        <p class="text-xs text-slate-500">

                                            {{ $transaction->user?->email }}

                                        </p>

                                    </td>


                                    <td
                                        class="whitespace-nowrap px-6 py-4
                                               text-sm text-slate-700">

                                        {{ $transaction->account?->name ?? 'Deleted Account' }}

                                    </td>


                                    <td
                                        class="whitespace-nowrap px-6 py-4
                                               text-sm text-slate-700">

                                        {{ $transaction->category?->name ?? 'Deleted Category' }}

                                    </td>


                                    <td class="whitespace-nowrap px-6 py-4">

                                        <span
                                            class="text-sm font-semibold
                                                {{ $transaction->type === 'income' ? 'text-green-600' : 'text-red-600' }}">

                                            {{ $transaction->type === 'income' ? '+' : '-' }}

                                            NPR {{ number_format($transaction->amount, 2) }}

                                        </span>

                                    </td>


                                    <td
                                        class="whitespace-nowrap px-6 py-4
                                               text-sm text-slate-500">

                                        {{ $transaction->transaction_date?->format('M d, Y') }}

                                    </td>

                                </tr>
                            @endforeach

                        </tbody>

                    </table>

                </div>
            @else
                <div class="p-10 text-center">

                    <h3 class="font-semibold text-slate-900">
                        No Pending Transactions
                    </h3>

                    <p class="mt-1 text-sm text-slate-500">

                        All transactions have been reviewed.

                    </p>

                </div>
            @endif

        </div>



        {{-- ============================================================
             QUICK ACTIONS
        ============================================================= --}}

        <div>

            <h2 class="mb-4 text-lg font-semibold text-slate-900">
                Quick Actions
            </h2>


            <div class="grid gap-4 sm:grid-cols-3">


                {{-- Add User --}}

                <a href="{{ route('admin.users.create') }}"
                    class="rounded-2xl border border-slate-200
                           bg-white p-5 shadow-sm transition
                           hover:-translate-y-0.5 hover:border-indigo-200
                           hover:shadow-md">

                    <p class="font-semibold text-slate-900">
                        Add User
                    </p>

                    <p class="mt-1 text-sm text-slate-500">
                        Create a new system user
                    </p>

                </a>


                {{-- Manage Users --}}

                <a href="{{ route('admin.users.index') }}"
                    class="rounded-2xl border border-slate-200
                           bg-white p-5 shadow-sm transition
                           hover:-translate-y-0.5 hover:border-indigo-200
                           hover:shadow-md">

                    <p class="font-semibold text-slate-900">
                        Manage Users
                    </p>

                    <p class="mt-1 text-sm text-slate-500">
                        View and manage system users
                    </p>

                </a>


                {{-- Manage Roles --}}

                <a href="{{ route('admin.roles.index') }}"
                    class="rounded-2xl border border-slate-200
                           bg-white p-5 shadow-sm transition
                           hover:-translate-y-0.5 hover:border-indigo-200
                           hover:shadow-md">

                    <p class="font-semibold text-slate-900">
                        Manage Roles
                    </p>

                    <p class="mt-1 text-sm text-slate-500">
                        Configure system roles
                    </p>

                </a>

            </div>

        </div>

    </div>

@endsection
