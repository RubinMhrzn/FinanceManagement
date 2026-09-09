@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-5xl space-y-8 py-6">

        {{-- Breadcrumb --}}
        <div class="flex items-center gap-2 text-sm text-slate-500">
            <a href="{{ url('/transactions') }}" class="hover:text-slate-800">
                Transactions
            </a>
            <span>/</span>
            <span class="text-slate-700">
                Transaction {{ $transaction->id }}
            </span>
        </div>


        {{-- Header --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <p class="text-sm font-medium text-slate-500">
                    Transaction {{ $transaction->id }}
                </p>

                <h1 class="mt-1 text-2xl font-bold text-slate-900 sm:text-3xl">
                    {{ $transaction->description ?: 'Transaction Details' }}
                </h1>

                <p class="mt-2 text-sm text-slate-500">
                    {{ $transaction->transaction_date->format('F d, Y') }}
                </p>
            </div>

            <div class="flex gap-3">

                <a href="{{ url('/transactions/' . $transaction->id . '/edit') }}"
                    class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white hover:bg-slate-800">
                    Edit
                </a>

                <a href="{{ url('/transactions') }}"
                    class="inline-flex items-center justify-center rounded-xl border border-slate-300 px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                    Back
                </a>

            </div>

        </div>


        {{-- Main Amount Card --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">

            <div class="flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between">

                <div>
                    <p class="text-sm font-medium text-slate-500">
                        {{ ucfirst($transaction->type) }}
                    </p>

                    <p
                        class="mt-2 text-4xl font-bold
                    {{ $transaction->type === 'income' ? 'text-emerald-600' : 'text-red-600' }}">
                        {{ $transaction->type === 'income' ? '+' : '-' }}
                        {{ number_format($transaction->amount, 2) }}
                    </p>
                </div>

                <div>
                    @if ($transaction->status === 'approved')
                        <span
                            class="inline-flex rounded-full bg-emerald-100 px-4 py-2 text-sm font-semibold text-emerald-700">
                            Approved
                        </span>
                    @elseif ($transaction->status === 'pending')
                        <span class="inline-flex rounded-full bg-amber-100 px-4 py-2 text-sm font-semibold text-amber-700">
                            Pending
                        </span>
                    @else
                        <span class="inline-flex rounded-full bg-red-100 px-4 py-2 text-sm font-semibold text-red-700">
                            Rejected
                        </span>
                    @endif
                </div>

            </div>

        </div>


        {{-- Details --}}
        <div class="grid gap-6 md:grid-cols-2">

            {{-- Transaction Information --}}
            <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">

                <div class="border-b border-slate-200 px-6 py-5">
                    <h2 class="font-semibold text-slate-900">
                        Transaction Information
                    </h2>
                </div>

                <div class="divide-y divide-slate-100">

                    <div class="flex justify-between gap-4 px-6 py-4">
                        <span class="text-sm text-slate-500">Type</span>
                        <span class="text-sm font-semibold text-slate-900">
                            {{ ucfirst($transaction->type) }}
                        </span>
                    </div>

                    <div class="flex justify-between gap-4 px-6 py-4">
                        <span class="text-sm text-slate-500">Amount</span>
                        <span class="text-sm font-semibold text-slate-900">
                            {{ number_format($transaction->amount, 2) }}
                        </span>
                    </div>

                    <div class="flex justify-between gap-4 px-6 py-4">
                        <span class="text-sm text-slate-500">Date</span>
                        <span class="text-sm font-semibold text-slate-900">
                            {{ $transaction->transaction_date->format('M d, Y') }}
                        </span>
                    </div>

                    <div class="flex justify-between gap-4 px-6 py-4">
                        <span class="text-sm text-slate-500">Status</span>
                        <span class="text-sm font-semibold text-slate-900">
                            {{ ucfirst($transaction->status) }}
                        </span>
                    </div>

                </div>

            </div>


            {{-- Related Information --}}
            <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">

                <div class="border-b border-slate-200 px-6 py-5">
                    <h2 class="font-semibold text-slate-900">
                        Related Information
                    </h2>
                </div>

                <div class="divide-y divide-slate-100">

                    <div class="px-6 py-4">
                        <p class="text-sm text-slate-500">
                            Account
                        </p>

                        <p class="mt-1 font-semibold text-slate-900">
                            {{ $transaction->account->name }}
                        </p>
                    </div>

                    <div class="px-6 py-4">
                        <p class="text-sm text-slate-500">
                            Category
                        </p>

                        <p class="mt-1 font-semibold text-slate-900">
                            {{ $transaction->category->name }}
                        </p>
                    </div>

                    <div class="px-6 py-4">
                        <p class="text-sm text-slate-500">
                            Created
                        </p>

                        <p class="mt-1 font-semibold text-slate-900">
                            {{ $transaction->created_at->format('M d, Y h:i A') }}
                        </p>
                    </div>

                </div>

            </div>

        </div>


        {{-- Description --}}
        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-200 px-6 py-5">
                <h2 class="font-semibold text-slate-900">
                    Description
                </h2>
            </div>

            <div class="px-6 py-6">

                @if ($transaction->description)
                    <p class="text-sm leading-7 text-slate-600">
                        {{ $transaction->description }}
                    </p>
                @else
                    <p class="text-sm italic text-slate-400">
                        No description provided.
                    </p>
                @endif

            </div>

        </div>

    </div>
@endsection
