@extends('layouts.app')

@section('title', 'Transaction Approvals')

@section('content')
    <div class="space-y-6">

        {{-- Header --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">
                    Transaction Approvals
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Review and approve or reject pending transactions.
                </p>
            </div>

            <div class="rounded-lg bg-amber-50 px-4 py-3 text-sm text-amber-700">
                Pending:
                <span class="font-bold">
                    {{ $transactions->count() }}
                </span>
            </div>
        </div>


        {{-- Pending Transactions --}}
        @if ($transactions->count() > 0)

            {{-- Desktop Table --}}
            <div class="hidden overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm md:block">

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">

                        <thead class="bg-slate-50">
                            <tr>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    User
                                </th>

                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    Account
                                </th>

                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    Category
                                </th>

                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    Type
                                </th>

                                <th
                                    class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    Amount
                                </th>

                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    Date
                                </th>

                                <th
                                    class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    Actions
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100">

                            @foreach ($transactions as $transaction)
                                <tr class="hover:bg-slate-50">

                                    {{-- User --}}
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <div class="font-medium text-slate-800">
                                            {{ $transaction->user->name }}
                                        </div>

                                        <div class="text-xs text-slate-500">
                                            {{ $transaction->user->email }}
                                        </div>
                                    </td>


                                    {{-- Account --}}
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <span class="text-sm text-slate-700">
                                            {{ $transaction->account->name }}
                                        </span>
                                    </td>


                                    {{-- Category --}}
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <span class="text-sm text-slate-700">
                                            {{ $transaction->category->name }}
                                        </span>
                                    </td>


                                    {{-- Type --}}
                                    <td class="whitespace-nowrap px-6 py-4">

                                        @if ($transaction->type === 'income')
                                            <span
                                                class="inline-flex rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">
                                                Income
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">
                                                Expense
                                            </span>
                                        @endif

                                    </td>


                                    {{-- Amount --}}
                                    <td class="whitespace-nowrap px-6 py-4 text-right">

                                        <span
                                            class="font-semibold
                                        {{ $transaction->type === 'income' ? 'text-emerald-600' : 'text-red-600' }}">

                                            {{ $transaction->account->currency }}
                                            {{ number_format((float) $transaction->amount, 2) }}

                                        </span>

                                    </td>


                                    {{-- Date --}}
                                    <td class="whitespace-nowrap px-6 py-4">

                                        <span class="text-sm text-slate-700">
                                            {{ $transaction->transaction_date->format('M d, Y') }}
                                        </span>

                                    </td>


                                    {{-- Actions --}}
                                    <td class="whitespace-nowrap px-6 py-4">

                                        <div class="flex justify-end gap-2">

                                            {{-- Approve --}}
                                            <form method="POST"
                                                action="{{ route('manager.transactions.approve', $transaction) }}">
                                                @csrf
                                                @method('PUT')

                                                <button type="submit"
                                                    onclick="return confirm('Are you sure you want to approve this transaction?')"
                                                    class="rounded-lg bg-emerald-600 px-3 py-2 text-xs font-semibold text-white transition hover:bg-emerald-700">
                                                    Approve
                                                </button>
                                            </form>


                                            {{-- Reject --}}
                                            <form method="POST"
                                                action="{{ route('manager.transactions.reject', $transaction) }}">
                                                @csrf
                                                @method('PUT')

                                                <button type="submit"
                                                    onclick="return confirm('Are you sure you want to reject this transaction?')"
                                                    class="rounded-lg bg-red-600 px-3 py-2 text-xs font-semibold text-white transition hover:bg-red-700">
                                                    Reject
                                                </button>
                                            </form>

                                        </div>

                                    </td>

                                </tr>

                                {{-- Description --}}
                                @if ($transaction->description)
                                    <tr class="bg-slate-50/50">

                                        <td colspan="7" class="px-6 py-3 text-sm text-slate-500">
                                            <span class="font-medium text-slate-600">
                                                Description:
                                            </span>

                                            {{ $transaction->description }}
                                        </td>

                                    </tr>
                                @endif
                            @endforeach

                        </tbody>

                    </table>
                </div>

            </div>


            {{-- Mobile Cards --}}
            <div class="space-y-4 md:hidden">

                @foreach ($transactions as $transaction)
                    <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">

                        {{-- Card Header --}}
                        <div class="flex items-start justify-between gap-4">

                            <div>
                                <h2 class="font-semibold text-slate-800">
                                    {{ $transaction->user->name }}
                                </h2>

                                <p class="text-xs text-slate-500">
                                    {{ $transaction->user->email }}
                                </p>
                            </div>


                            @if ($transaction->type === 'income')
                                <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">
                                    Income
                                </span>
                            @else
                                <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">
                                    Expense
                                </span>
                            @endif

                        </div>


                        {{-- Amount --}}
                        <div class="mt-5">

                            <p class="text-xs font-medium uppercase text-slate-400">
                                Amount
                            </p>

                            <p
                                class="mt-1 text-2xl font-bold
                            {{ $transaction->type === 'income' ? 'text-emerald-600' : 'text-red-600' }}">

                                {{ $transaction->account->currency }}
                                {{ number_format((float) $transaction->amount, 2) }}

                            </p>

                        </div>


                        {{-- Details --}}
                        <div class="mt-5 grid grid-cols-2 gap-4">

                            <div>
                                <p class="text-xs text-slate-400">
                                    Account
                                </p>

                                <p class="mt-1 text-sm font-medium text-slate-700">
                                    {{ $transaction->account->name }}
                                </p>
                            </div>


                            <div>
                                <p class="text-xs text-slate-400">
                                    Category
                                </p>

                                <p class="mt-1 text-sm font-medium text-slate-700">
                                    {{ $transaction->category->name }}
                                </p>
                            </div>


                            <div>
                                <p class="text-xs text-slate-400">
                                    Date
                                </p>

                                <p class="mt-1 text-sm font-medium text-slate-700">
                                    {{ $transaction->transaction_date->format('M d, Y') }}
                                </p>
                            </div>


                            <div>
                                <p class="text-xs text-slate-400">
                                    Status
                                </p>

                                <span
                                    class="mt-1 inline-flex rounded-full bg-amber-100 px-2 py-1 text-xs font-semibold text-amber-700">
                                    Pending
                                </span>
                            </div>

                        </div>


                        {{-- Description --}}
                        @if ($transaction->description)
                            <div class="mt-5 rounded-lg bg-slate-50 p-3">

                                <p class="text-xs font-medium text-slate-400">
                                    Description
                                </p>

                                <p class="mt-1 text-sm text-slate-600">
                                    {{ $transaction->description }}
                                </p>

                            </div>
                        @endif


                        {{-- Actions --}}
                        <div class="mt-5 grid grid-cols-2 gap-3">

                            {{-- Approve --}}
                            <form method="POST" action="{{ route('manager.transactions.approve', $transaction) }}">
                                @csrf
                                @method('PUT')

                                <button type="submit"
                                    onclick="return confirm('Are you sure you want to approve this transaction?')"
                                    class="w-full rounded-lg bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-emerald-700">
                                    Approve
                                </button>
                            </form>


                            {{-- Reject --}}
                            <form method="POST" action="{{ route('manager.transactions.reject', $transaction) }}">
                                @csrf
                                @method('PUT')

                                <button type="submit"
                                    onclick="return confirm('Are you sure you want to reject this transaction?')"
                                    class="w-full rounded-lg bg-red-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-red-700">
                                    Reject
                                </button>
                            </form>

                        </div>

                    </div>
                @endforeach

            </div>
        @else
            {{-- Empty State --}}
            <div class="rounded-xl border border-slate-200 bg-white px-6 py-16 text-center shadow-sm">

                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-emerald-100">
                    <svg class="h-8 w-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>

                <h2 class="mt-5 text-lg font-semibold text-slate-800">
                    No Pending Transactions
                </h2>

                <p class="mx-auto mt-2 max-w-md text-sm text-slate-500">
                    There are currently no transactions waiting for your approval.
                </p>

            </div>

        @endif

    </div>
@endsection
