@extends('layouts.app')

@section('content')

    <div class="mx-auto max-w-4xl space-y-8 py-6">

        {{-- Header --}}
        <div>
            <div class="flex items-center gap-2 text-sm text-slate-500">
                <a href="{{ url('/transactions') }}" class="hover:text-slate-800">
                    Transactions
                </a>

                <span>/</span>

                <span class="text-slate-700">
                    Create
                </span>
            </div>

            <div class="mt-3">
                <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                    Add Transaction
                </h1>

                <p class="mt-1 text-sm text-slate-500 sm:text-base">
                    Record your income or expense.
                </p>
            </div>
        </div>


        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="rounded-xl border border-red-200 bg-red-50 p-4">
                <h3 class="font-semibold text-red-800">
                    Please fix the following errors:
                </h3>

                <ul class="mt-2 list-inside list-disc space-y-1 text-sm text-red-700">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        {{-- Form --}}
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-200 px-5 py-5 sm:px-7">
                <h2 class="text-lg font-semibold text-slate-900">
                    Transaction Details
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Enter the details of your financial transaction.
                </p>
            </div>


            <form action="{{ url('/transactions') }}" method="POST" class="space-y-7 p-5 sm:p-7">

                @csrf


                {{-- Transaction Type --}}
                <div>
                    <label class="mb-3 block text-sm font-medium text-slate-700">
                        Transaction Type
                        <span class="text-red-500">*</span>
                    </label>

                    <div class="grid gap-4 sm:grid-cols-2">

                        {{-- Income --}}
                        <label class="cursor-pointer">
                            <input type="radio" name="type" value="income" class="peer sr-only"
                                {{ old('type') === 'income' ? 'checked' : '' }}>

                            <div
                                class="rounded-2xl border-2 border-slate-200 p-5 transition hover:border-slate-300 peer-checked:border-emerald-500 peer-checked:bg-emerald-50">

                                <div class="flex items-center gap-4">
                                    <div
                                        class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-100 text-xl font-bold text-emerald-600">
                                        ↑
                                    </div>

                                    <div>
                                        <p class="font-semibold text-slate-900">
                                            Income
                                        </p>

                                        <p class="mt-1 text-sm text-slate-500">
                                            Money coming into your account.
                                        </p>
                                    </div>
                                </div>

                            </div>
                        </label>


                        {{-- Expense --}}
                        <label class="cursor-pointer">
                            <input type="radio" name="type" value="expense" class="peer sr-only"
                                {{ old('type') === 'expense' ? 'checked' : '' }}>

                            <div
                                class="rounded-2xl border-2 border-slate-200 p-5 transition hover:border-slate-300 peer-checked:border-red-500 peer-checked:bg-red-50">

                                <div class="flex items-center gap-4">
                                    <div
                                        class="flex h-11 w-11 items-center justify-center rounded-xl bg-red-100 text-xl font-bold text-red-600">
                                        ↓
                                    </div>

                                    <div>
                                        <p class="font-semibold text-slate-900">
                                            Expense
                                        </p>

                                        <p class="mt-1 text-sm text-slate-500">
                                            Money going out of your account.
                                        </p>
                                    </div>
                                </div>

                            </div>
                        </label>

                    </div>

                    @error('type')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>


                {{-- Account + Category --}}
                <div class="grid gap-6 md:grid-cols-2">

                    {{-- Account --}}
                    <div>
                        <label for="account_id" class="mb-2 block text-sm font-medium text-slate-700">
                            Account
                            <span class="text-red-500">*</span>
                        </label>

                        <select name="account_id" id="account_id"
                            class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none focus:border-slate-500 focus:ring-2 focus:ring-slate-200">
                            <option value="">
                                Select account
                            </option>

                            @foreach ($accounts as $account)
                                <option value="{{ $account->id }}"
                                    {{ old('account_id') == $account->id ? 'selected' : '' }}>
                                    {{ $account->name }}
                                    — {{ $account->currency }}
                                    {{ number_format($account->balance, 2) }}
                                </option>
                            @endforeach

                        </select>

                        @error('account_id')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>


                    {{-- Category --}}
                    <div>
                        <label for="category_id" class="mb-2 block text-sm font-medium text-slate-700">
                            Category
                            <span class="text-red-500">*</span>
                        </label>

                        <select name="category_id" id="category_id"
                            class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none focus:border-slate-500 focus:ring-2 focus:ring-slate-200">
                            <option value="">
                                Select category
                            </option>

                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                    — {{ ucfirst($category->type) }}
                                </option>
                            @endforeach

                        </select>

                        @error('category_id')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                </div>


                {{-- Amount + Date --}}
                <div class="grid gap-6 md:grid-cols-2">

                    {{-- Amount --}}
                    <div>
                        <label for="amount" class="mb-2 block text-sm font-medium text-slate-700">
                            Amount
                            <span class="text-red-500">*</span>
                        </label>

                        <input type="number" name="amount" id="amount" step="0.01" min="0.01"
                            value="{{ old('amount') }}" placeholder="0.00"
                            class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none placeholder:text-slate-400 focus:border-slate-500 focus:ring-2 focus:ring-slate-200">

                        @error('amount')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>


                    {{-- Date --}}
                    <div>
                        <label for="transaction_date" class="mb-2 block text-sm font-medium text-slate-700">
                            Transaction Date
                            <span class="text-red-500">*</span>
                        </label>

                        <input type="date" name="transaction_date" id="transaction_date"
                            value="{{ old('transaction_date', now()->format('Y-m-d')) }}"
                            class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none focus:border-slate-500 focus:ring-2 focus:ring-slate-200">

                        @error('transaction_date')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                </div>


                {{-- Description --}}
                <div>
                    <label for="description" class="mb-2 block text-sm font-medium text-slate-700">
                        Description
                    </label>

                    <textarea name="description" id="description" rows="4"
                        placeholder="e.g. Monthly salary, groceries, electricity bill..."
                        class="w-full resize-none rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none placeholder:text-slate-400 focus:border-slate-500 focus:ring-2 focus:ring-slate-200">{{ old('description') }}</textarea>

                    @error('description')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>


                {{-- Status --}}
                <div>
                    <label for="status" class="mb-2 block text-sm font-medium text-slate-700">
                        Status
                    </label>

                    <select name="status" id="status"
                        class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none focus:border-slate-500 focus:ring-2 focus:ring-slate-200">
                        <option value="pending" {{ old('status', 'pending') === 'pending' ? 'selected' : '' }}>
                            Pending
                        </option>

                        <option value="approved" {{ old('status') === 'approved' ? 'selected' : '' }}>
                            Approved
                        </option>

                        <option value="rejected" {{ old('status') === 'rejected' ? 'selected' : '' }}>
                            Rejected
                        </option>
                    </select>

                    <p class="mt-2 text-xs text-slate-500">
                        New transactions normally start as pending.
                    </p>

                    @error('status')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>


                {{-- Buttons --}}
                <div class="flex flex-col-reverse gap-3 border-t border-slate-200 pt-6 sm:flex-row sm:justify-end">

                    <a href="{{ url('/transactions') }}"
                        class="inline-flex items-center justify-center rounded-xl border border-slate-300 px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                        Cancel
                    </a>

                    <button type="submit"
                        class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-400 focus:ring-offset-2">
                        Save Transaction
                    </button>

                </div>

            </form>

        </div>

    </div>

@endsection
