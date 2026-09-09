@extends('layouts.app')

@section('content')
    <div class="space-y-6">

        {{-- Header --}}
        <div>
            <p class="text-sm font-semibold text-indigo-600">
                Admin Panel
            </p>

            <h1 class="mt-1 text-2xl font-bold text-slate-900">
                All Transactions
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                View and manage all user transactions.
            </p>
        </div>


        {{-- Filters --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

            <form method="GET" action="{{ route('admin.transactions.index') }}"
                class="grid grid-cols-1 gap-4 md:grid-cols-3">

                {{-- Status --}}
                <div>
                    <label for="status" class="mb-1 block text-sm font-medium text-slate-700">
                        Status
                    </label>

                    <select id="status" name="status"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">

                        <option value="">
                            All Statuses
                        </option>

                        <option value="pending" @selected(request('status') === 'pending')>
                            Pending
                        </option>

                        <option value="approved" @selected(request('status') === 'approved')>
                            Approved
                        </option>

                        <option value="rejected" @selected(request('status') === 'rejected')>
                            Rejected
                        </option>

                    </select>
                </div>


                {{-- Type --}}
                <div>
                    <label for="type" class="mb-1 block text-sm font-medium text-slate-700">
                        Type
                    </label>

                    <select id="type" name="type"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">

                        <option value="">
                            All Types
                        </option>

                        <option value="income" @selected(request('type') === 'income')>
                            Income
                        </option>

                        <option value="expense" @selected(request('type') === 'expense')>
                            Expense
                        </option>

                    </select>
                </div>


                {{-- Buttons --}}
                <div class="flex items-end gap-2">

                    <button type="submit"
                        class="rounded-lg bg-indigo-600 px-4 py-2 text-sm
                    font-semibold text-white hover:bg-indigo-700">
                        Filter
                    </button>

                    <a href="{{ route('admin.transactions.index') }}"
                        class="rounded-lg border border-slate-300 px-4 py-2
                    text-sm font-semibold text-slate-700 hover:bg-slate-50">
                        Reset
                    </a>

                </div>

            </form>

        </div>


        {{-- Transactions Table --}}
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

            <div class="overflow-x-auto">

                <table class="min-w-full divide-y divide-slate-200">

                    <thead class="bg-slate-50">

                        <tr>

                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-slate-500">
                                User
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-slate-500">
                                Account
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-slate-500">
                                Category
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-slate-500">
                                Type
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-slate-500">
                                Amount
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-slate-500">
                                Date
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-slate-500">
                                Status
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-slate-500">
                                Action
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-slate-200">

                        @forelse ($transactions as $transaction)
                            <tr class="hover:bg-slate-50">

                                {{-- User --}}
                                <td class="px-6 py-4">

                                    <div class="font-medium text-slate-900">
                                        {{ $transaction->user->name }}
                                    </div>

                                    <div class="text-xs text-slate-500">
                                        {{ $transaction->user->email }}
                                    </div>

                                </td>


                                {{-- Account --}}
                                <td class="px-6 py-4 text-sm text-slate-700">
                                    {{ $transaction->account->name }}
                                </td>


                                {{-- Category --}}
                                <td class="px-6 py-4 text-sm text-slate-700">
                                    {{ $transaction->category->name }}
                                </td>


                                {{-- Type --}}
                                <td class="px-6 py-4">

                                    @if ($transaction->type === 'income')
                                        <span
                                            class="inline-flex rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-semibold text-emerald-700">
                                            Income
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex rounded-full bg-red-100 px-2.5 py-1 text-xs font-semibold text-red-700">
                                            Expense
                                        </span>
                                    @endif

                                </td>


                                {{-- Amount --}}
                                <td class="px-6 py-4 text-sm font-semibold text-slate-900">

                                    NPR {{ number_format($transaction->amount, 2) }}

                                </td>


                                {{-- Date --}}
                                <td class="px-6 py-4 text-sm text-slate-700">

                                    {{ $transaction->transaction_date->format('M d, Y') }}

                                </td>


                                {{-- Status --}}
                                <td class="px-6 py-4">

                                    @if ($transaction->status === 'pending')
                                        <span
                                            class="inline-flex rounded-full bg-amber-100 px-2.5 py-1 text-xs font-semibold text-amber-700">
                                            Pending
                                        </span>
                                    @elseif ($transaction->status === 'approved')
                                        <span
                                            class="inline-flex rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-semibold text-emerald-700">
                                            Approved
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex rounded-full bg-red-100 px-2.5 py-1 text-xs font-semibold text-red-700">
                                            Rejected
                                        </span>
                                    @endif

                                </td>


                                {{-- ACTION --}}
                                <td class="px-6 py-4">

                                    @if ($transaction->status === 'pending')
                                        <div class="flex items-center gap-2">

                                            {{-- Approve --}}
                                            <form method="POST"
                                                action="{{ route('admin.transactions.approve', $transaction) }}">

                                                @csrf
                                                @method('PUT')

                                                <button type="submit"
                                                    class="rounded-lg bg-emerald-600 px-3 py-2
                                                text-xs font-semibold text-white
                                                hover:bg-emerald-700"
                                                    onclick="return confirm('Approve this transaction?')">
                                                    Approve
                                                </button>

                                            </form>


                                            {{-- Reject --}}
                                            <form method="POST"
                                                action="{{ route('admin.transactions.reject', $transaction) }}">

                                                @csrf
                                                @method('PUT')

                                                <button type="submit"
                                                    class="rounded-lg bg-red-600 px-3 py-2
                                                text-xs font-semibold text-white
                                                hover:bg-red-700"
                                                    onclick="return confirm('Reject this transaction?')">
                                                    Reject
                                                </button>

                                            </form>

                                        </div>
                                    @else
                                        <span class="text-xs text-slate-400">
                                            No actions
                                        </span>
                                    @endif

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="8" class="px-6 py-12 text-center text-sm text-slate-500">
                                    No transactions found.
                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>
@endsection
