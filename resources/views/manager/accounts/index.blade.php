@extends('layouts.app')

@section('title', 'All Accounts')

@section('content')

    <div class="mx-auto max-w-7xl space-y-8 py-6">


        {{-- ================= HEADER ================= --}}
        <div>
            <p class="text-sm font-medium text-indigo-600">
                Financial Accounts
            </p>

            <h1 class="mt-1 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                All User Accounts
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                View accounts and balances across all users.
            </p>
        </div>


        {{-- ================= SUMMARY ================= --}}
        <div class="grid gap-5 sm:grid-cols-3">

            {{-- Total Accounts --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                <div class="flex items-center gap-4">

                    <div
                        class="flex h-12 w-12 items-center justify-center
                        rounded-xl bg-indigo-50 text-indigo-600">

                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h2m4 0h2m-8 4h10
                                     a2 2 0 002-2V7a2 2 0 00-2-2H5
                                     a2 2 0 00-2 2v10a2 2 0 002 2z" />

                        </svg>

                    </div>

                    <div>
                        <p class="text-sm text-slate-500">
                            Total Accounts
                        </p>

                        <p class="mt-1 text-2xl font-bold text-slate-900">
                            {{ $accounts->count() }}
                        </p>
                    </div>

                </div>

            </div>


            {{-- Total Balance --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                <div class="flex items-center gap-4">

                    <div
                        class="flex h-12 w-12 items-center justify-center
                        rounded-xl bg-green-50 text-green-600">

                        <span class="text-xl font-bold">
                            ₨
                        </span>

                    </div>

                    <div>
                        <p class="text-sm text-slate-500">
                            Total Balance
                        </p>

                        <p class="mt-1 text-2xl font-bold text-slate-900">
                            NPR {{ number_format($accounts->sum('balance'), 2) }}
                        </p>
                    </div>

                </div>

            </div>


            {{-- Active Accounts --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                <div class="flex items-center gap-4">

                    <div
                        class="flex h-12 w-12 items-center justify-center
                        rounded-xl bg-blue-50 text-blue-600">

                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />

                        </svg>

                    </div>

                    <div>
                        <p class="text-sm text-slate-500">
                            Active Accounts
                        </p>

                        <p class="mt-1 text-2xl font-bold text-slate-900">
                            {{ $accounts->where('is_active', true)->count() }}
                        </p>
                    </div>

                </div>

            </div>

        </div>


        {{-- ================= ACCOUNTS ================= --}}
        @if ($accounts->count())

            <div>

                <div class="mb-5">
                    <h2 class="text-lg font-semibold text-slate-900">
                        User Accounts
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">
                        All financial accounts registered by users.
                    </p>
                </div>


                {{-- ================= DESKTOP TABLE ================= --}}
                <div
                    class="hidden overflow-hidden rounded-2xl border border-slate-200
                    bg-white shadow-sm md:block">

                    <div class="overflow-x-auto">

                        <table class="min-w-full divide-y divide-slate-200">

                            <thead class="bg-slate-50">

                                <tr>

                                    <th
                                        class="px-6 py-4 text-left text-xs font-semibold
                                       uppercase tracking-wider text-slate-500">
                                        User
                                    </th>

                                    <th
                                        class="px-6 py-4 text-left text-xs font-semibold
                                       uppercase tracking-wider text-slate-500">
                                        Account
                                    </th>

                                    <th
                                        class="px-6 py-4 text-left text-xs font-semibold
                                       uppercase tracking-wider text-slate-500">
                                        Type
                                    </th>

                                    <th
                                        class="px-6 py-4 text-right text-xs font-semibold
                                       uppercase tracking-wider text-slate-500">
                                        Balance
                                    </th>

                                    <th
                                        class="px-6 py-4 text-left text-xs font-semibold
                                       uppercase tracking-wider text-slate-500">
                                        Status
                                    </th>

                                </tr>

                            </thead>


                            <tbody class="divide-y divide-slate-100">

                                @foreach ($accounts as $account)
                                    <tr class="transition hover:bg-slate-50">

                                        {{-- User --}}
                                        <td class="whitespace-nowrap px-6 py-4">

                                            <div class="font-medium text-slate-800">
                                                {{ $account->user->name }}
                                            </div>

                                            <div class="mt-1 text-xs text-slate-500">
                                                {{ $account->user->email }}
                                            </div>

                                        </td>


                                        {{-- Account --}}
                                        <td class="whitespace-nowrap px-6 py-4">

                                            <div class="font-medium text-slate-800">
                                                {{ $account->name }}
                                            </div>

                                            <div class="mt-1 text-xs text-slate-500">
                                                {{ strtoupper($account->currency) }}
                                            </div>

                                        </td>


                                        {{-- Type --}}
                                        <td class="whitespace-nowrap px-6 py-4">

                                            <span
                                                class="inline-flex rounded-full
                                                 bg-indigo-50 px-3 py-1
                                                 text-xs font-semibold
                                                 capitalize text-indigo-700">

                                                {{ $account->type }}

                                            </span>

                                        </td>


                                        {{-- Balance --}}
                                        <td class="whitespace-nowrap px-6 py-4 text-right">

                                            <span class="font-semibold text-slate-900">

                                                {{ $account->currency }}
                                                {{ number_format((float) $account->balance, 2) }}

                                            </span>

                                        </td>


                                        {{-- Status --}}
                                        <td class="whitespace-nowrap px-6 py-4">

                                            @if ($account->is_active)
                                                <span
                                                    class="inline-flex rounded-full
                                                     bg-green-50 px-3 py-1
                                                     text-xs font-semibold
                                                     text-green-700">

                                                    Active

                                                </span>
                                            @else
                                                <span
                                                    class="inline-flex rounded-full
                                                     bg-slate-100 px-3 py-1
                                                     text-xs font-semibold
                                                     text-slate-500">

                                                    Inactive

                                                </span>
                                            @endif

                                        </td>

                                    </tr>
                                @endforeach

                            </tbody>

                        </table>

                    </div>

                </div>


                {{-- ================= MOBILE CARDS ================= --}}
                <div class="space-y-4 md:hidden">

                    @foreach ($accounts as $account)
                        <div class="rounded-2xl border border-slate-200
                            bg-white p-5 shadow-sm">

                            {{-- Header --}}
                            <div class="flex items-start justify-between gap-4">

                                <div>

                                    <h2 class="font-semibold text-slate-800">
                                        {{ $account->name }}
                                    </h2>

                                    <p class="mt-1 text-xs text-slate-500">
                                        {{ $account->user->name }}
                                    </p>

                                    <p class="text-xs text-slate-400">
                                        {{ $account->user->email }}
                                    </p>

                                </div>


                                @if ($account->is_active)
                                    <span
                                        class="shrink-0 rounded-full
                                         bg-green-50 px-3 py-1
                                         text-xs font-semibold
                                         text-green-700">

                                        Active

                                    </span>
                                @else
                                    <span
                                        class="shrink-0 rounded-full
                                         bg-slate-100 px-3 py-1
                                         text-xs font-semibold
                                         text-slate-500">

                                        Inactive

                                    </span>
                                @endif

                            </div>


                            {{-- Balance --}}
                            <div class="mt-5">

                                <p
                                    class="text-xs font-medium uppercase tracking-wide
                                  text-slate-400">

                                    Current Balance

                                </p>

                                <p class="mt-1 text-2xl font-bold text-slate-900">

                                    {{ $account->currency }}
                                    {{ number_format((float) $account->balance, 2) }}

                                </p>

                            </div>


                            {{-- Details --}}
                            <div class="mt-5 grid grid-cols-2 gap-4">

                                <div>

                                    <p class="text-xs text-slate-400">
                                        Account Type
                                    </p>

                                    <p
                                        class="mt-1 text-sm font-medium capitalize
                                      text-slate-700">

                                        {{ $account->type }}

                                    </p>

                                </div>


                                <div>

                                    <p class="text-xs text-slate-400">
                                        Currency
                                    </p>

                                    <p class="mt-1 text-sm font-medium text-slate-700">

                                        {{ strtoupper($account->currency) }}

                                    </p>

                                </div>

                            </div>

                        </div>
                    @endforeach

                </div>

            </div>
        @else
            {{-- ================= EMPTY STATE ================= --}}
            <div class="rounded-2xl border border-dashed border-slate-300
                bg-white px-6 py-16 text-center">

                <div
                    class="mx-auto flex h-16 w-16 items-center justify-center
                    rounded-2xl bg-indigo-50 text-indigo-600">

                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h2m4 0h2m-8 4h10
                                 a2 2 0 002-2V7a2 2 0 00-2-2H5
                                 a2 2 0 00-2 2v10a2 2 0 002 2z" />

                    </svg>

                </div>


                <h2 class="mt-5 text-lg font-semibold text-slate-900">
                    No Accounts Found
                </h2>

                <p class="mx-auto mt-2 max-w-md text-sm text-slate-500">
                    There are currently no financial accounts registered by users.
                </p>

            </div>

        @endif


    </div>

@endsection
