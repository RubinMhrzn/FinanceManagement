@extends('layouts.app')

@section('content')

    <div class="mx-auto max-w-6xl space-y-8 py-6">

        {{-- Header --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <div class="flex items-center gap-2 text-sm text-slate-500">
                    <a href="{{ url('/accounts') }}" class="hover:text-slate-800">
                        Accounts
                    </a>

                    <span>/</span>

                    <span class="text-slate-700">
                        {{ $account->name }}
                    </span>
                </div>

                <div class="mt-3">
                    <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                        {{ $account->name }}
                    </h1>

                    <p class="mt-1 text-sm text-slate-500">
                        Account details and recent transactions
                    </p>
                </div>
            </div>

            <div class="flex gap-3">
                <a href="{{ url('/accounts/' . $account->id . '/edit') }}"
                    class="inline-flex items-center justify-center rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">
                    Edit Account
                </a>

                <a href="{{ url('/accounts') }}"
                    class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-slate-800">
                    Back
                </a>
            </div>

        </div>


        {{-- Account Overview --}}
        <div class="grid gap-6 md:grid-cols-3">

            {{-- Balance --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-medium text-slate-500">
                    Current Balance
                </p>

                <p class="mt-3 text-3xl font-bold tracking-tight text-slate-900">
                    {{ $account->currency }}
                    {{ number_format($account->balance, 2) }}
                </p>

                <p class="mt-2 text-xs text-slate-500">
                    Available account balance
                </p>
            </div>


            {{-- Account Type --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-medium text-slate-500">
                    Account Type
                </p>

                <p class="mt-3 text-xl font-bold capitalize text-slate-900">
                    {{ str_replace('_', ' ', $account->type) }}
                </p>

                <p class="mt-2 text-xs text-slate-500">
                    {{ $account->currency }} currency
                </p>
            </div>


            {{-- Status --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-medium text-slate-500">
                    Status
                </p>

                <div class="mt-4">

                    @if ($account->is_active)
                        <span
                            class="inline-flex items-center rounded-full bg-emerald-50 px-3 py-1.5 text-sm font-semibold text-emerald-700">
                            <span class="mr-2 h-2 w-2 rounded-full bg-emerald-500"></span>
                            Active
                        </span>
                    @else
                        <span
                            class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1.5 text-sm font-semibold text-slate-600">
                            <span class="mr-2 h-2 w-2 rounded-full bg-slate-400"></span>
                            Inactive
                        </span>
                    @endif

                </div>

                <p class="mt-3 text-xs text-slate-500">
                    Account status
                </p>
            </div>

        </div>


        {{-- Account Information --}}
        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-200 px-6 py-5">
                <h2 class="text-lg font-semibold text-slate-900">
                    Account Information
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Basic information about this account.
                </p>
            </div>

            <div class="grid gap-6 px-6 py-6 sm:grid-cols-2 lg:grid-cols-4">

                <div>
                    <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                        Account Name
                    </p>

                    <p class="mt-2 font-semibold text-slate-800">
                        {{ $account->name }}
                    </p>
                </div>

                <div>
                    <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                        Type
                    </p>

                    <p class="mt-2 font-semibold capitalize text-slate-800">
                        {{ str_replace('_', ' ', $account->type) }}
                    </p>
                </div>

                <div>
                    <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                        Currency
                    </p>

                    <p class="mt-2 font-semibold text-slate-800">
                        {{ $account->currency }}
                    </p>
                </div>

                <div>
                    <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                        Created
                    </p>

                    <p class="mt-2 font-semibold text-slate-800">
                        {{ $account->created_at->format('M d, Y') }}
                    </p>
                </div>

            </div>

        </div>


        {{-- Recent Transactions --}}
        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">

            <div class="flex items-center justify-between border-b border-slate-200 px-6 py-5">

                <div>
                    <h2 class="text-lg font-semibold text-slate-900">
                        Recent Transactions
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">
                        Latest transactions from this account.
                    </p>
                </div>

                <a href="{{ url('/transactions/create') }}"
                    class="hidden rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-slate-800 sm:inline-flex">
                    Add Transaction
                </a>

            </div>


            @if ($account->transactions->count())
                <div class="divide-y divide-slate-100">

                    @foreach ($account->transactions->take(5) as $transaction)
                        <div class="flex flex-col gap-3 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">

                            <div class="flex items-center gap-4">

                                <div
                                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl
                                {{ $transaction->type === 'income' ? 'bg-emerald-50 text-emerald-600' : 'bg-red-50 text-red-600' }}">

                                    {{ $transaction->type === 'income' ? '+' : '-' }}

                                </div>

                                <div>
                                    <p class="font-semibold text-slate-800">
                                        {{ $transaction->category->name ?? 'Uncategorized' }}
                                    </p>

                                    <p class="mt-1 text-xs text-slate-500">
                                        {{ $transaction->transaction_date->format('M d, Y') }}

                                        @if ($transaction->description)
                                            · {{ $transaction->description }}
                                        @endif
                                    </p>
                                </div>

                            </div>


                            <div class="flex items-center justify-between gap-4 sm:justify-end">

                                <span
                                    class="font-bold
                                {{ $transaction->type === 'income' ? 'text-emerald-600' : 'text-red-600' }}">

                                    {{ $transaction->type === 'income' ? '+' : '-' }}
                                    {{ $account->currency }}
                                    {{ number_format($transaction->amount, 2) }}

                                </span>

                                <span
                                    class="rounded-full px-2.5 py-1 text-xs font-semibold
                                {{ $transaction->status === 'approved'
                                    ? 'bg-emerald-50 text-emerald-700'
                                    : ($transaction->status === 'rejected'
                                        ? 'bg-red-50 text-red-700'
                                        : 'bg-amber-50 text-amber-700') }}">

                                    {{ ucfirst($transaction->status) }}

                                </span>

                            </div>

                        </div>
                    @endforeach

                </div>
            @else
                {{-- Empty State --}}
                <div class="px-6 py-14 text-center">

                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-2xl">
                        ₿
                    </div>

                    <h3 class="mt-4 text-base font-semibold text-slate-900">
                        No transactions yet
                    </h3>

                    <p class="mx-auto mt-1 max-w-sm text-sm text-slate-500">
                        Transactions associated with this account will appear here.
                    </p>

                    <a href="{{ url('/transactions/create') }}"
                        class="mt-5 inline-flex rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-slate-800">
                        Add Transaction
                    </a>

                </div>
            @endif

        </div>


        {{-- Mobile Add Transaction --}}
        <div class="sm:hidden">
            <a href="{{ url('/transactions/create') }}"
                class="flex w-full items-center justify-center rounded-xl bg-slate-900 px-4 py-3 text-sm font-semibold text-white hover:bg-slate-800">
                Add Transaction
            </a>
        </div>

    </div>

@endsection
