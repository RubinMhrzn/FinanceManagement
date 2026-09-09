@extends('layouts.app')

@section('content')

    <div class="mx-auto max-w-4xl space-y-8 py-6">

        {{-- Page Header --}}
        <div>
            <div class="flex items-center gap-2 text-sm text-slate-500">
                <a href="{{ url('/accounts') }}" class="hover:text-slate-800">
                    Accounts
                </a>

                <span>/</span>

                <span class="text-slate-700">
                    Create
                </span>
            </div>

            <div class="mt-3">
                <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                    Create Account
                </h1>

                <p class="mt-1 text-sm text-slate-500 sm:text-base">
                    Add a bank account, wallet, cash account, or credit card.
                </p>
            </div>
        </div>


        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="rounded-xl border border-red-200 bg-red-50 p-4">
                <div class="flex gap-3">
                    <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-red-100 text-red-600">
                        !
                    </div>

                    <div>
                        <h3 class="font-semibold text-red-800">
                            Please fix the following errors:
                        </h3>

                        <ul class="mt-2 list-inside list-disc space-y-1 text-sm text-red-700">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif


        {{-- Form Card --}}
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

            {{-- Card Header --}}
            <div class="border-b border-slate-200 px-5 py-5 sm:px-7">
                <h2 class="text-lg font-semibold text-slate-900">
                    Account Information
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Enter the details of your financial account.
                </p>
            </div>


            {{-- Form --}}
            <form action="{{ url('/accounts') }}" method="POST" class="space-y-6 p-5 sm:p-7">

                @csrf

                {{-- Account Name --}}
                <div>
                    <label for="name" class="mb-2 block text-sm font-medium text-slate-700">
                        Account Name
                        <span class="text-red-500">*</span>
                    </label>

                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                        placeholder="e.g. Nabil Bank"
                        class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-slate-500 focus:ring-2 focus:ring-slate-200">

                    @error('name')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>


                {{-- Account Type + Currency --}}
                <div class="grid gap-6 md:grid-cols-2">

                    {{-- Account Type --}}
                    <div>
                        <label for="type" class="mb-2 block text-sm font-medium text-slate-700">
                            Account Type
                            <span class="text-red-500">*</span>
                        </label>

                        <select name="type" id="type"
                            class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-slate-500 focus:ring-2 focus:ring-slate-200">
                            <option value="">Select account type</option>

                            <option value="bank" {{ old('type') === 'bank' ? 'selected' : '' }}>
                                Bank Account
                            </option>

                            <option value="cash" {{ old('type') === 'cash' ? 'selected' : '' }}>
                                Cash
                            </option>

                            <option value="wallet" {{ old('type') === 'wallet' ? 'selected' : '' }}>
                                Digital Wallet
                            </option>

                            <option value="credit_card" {{ old('type') === 'credit_card' ? 'selected' : '' }}>
                                Credit Card
                            </option>
                        </select>

                        @error('type')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>


                    {{-- Currency --}}
                    <div>
                        <label for="currency" class="mb-2 block text-sm font-medium text-slate-700">
                            Currency
                            <span class="text-red-500">*</span>
                        </label>

                        <select name="currency" id="currency"
                            class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-slate-500 focus:ring-2 focus:ring-slate-200">
                            <option value="NPR" {{ old('currency', 'NPR') === 'NPR' ? 'selected' : '' }}>
                                NPR — Nepalese Rupee
                            </option>

                            <option value="USD" {{ old('currency') === 'USD' ? 'selected' : '' }}>
                                USD — US Dollar
                            </option>

                            <option value="INR" {{ old('currency') === 'INR' ? 'selected' : '' }}>
                                INR — Indian Rupee
                            </option>

                            <option value="EUR" {{ old('currency') === 'EUR' ? 'selected' : '' }}>
                                EUR — Euro
                            </option>

                            <option value="GBP" {{ old('currency') === 'GBP' ? 'selected' : '' }}>
                                GBP — British Pound
                            </option>
                        </select>

                        @error('currency')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                </div>


                {{-- Opening Balance --}}
                <div>
                    <label for="balance" class="mb-2 block text-sm font-medium text-slate-700">
                        Opening Balance
                    </label>

                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-sm font-medium text-slate-400">
                            NPR
                        </span>

                        <input type="number" name="balance" id="balance" step="0.01" min="0"
                            value="{{ old('balance', 0) }}" placeholder="0.00"
                            class="w-full rounded-xl border border-slate-300 bg-white py-3 pl-14 pr-4 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-slate-500 focus:ring-2 focus:ring-slate-200">
                    </div>

                    <p class="mt-2 text-xs text-slate-500">
                        Enter the current balance when adding this account.
                    </p>

                    @error('balance')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>


                {{-- Active Account --}}
                <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">

                    <label class="flex cursor-pointer items-start gap-3">

                        <input type="checkbox" name="is_active" value="1"
                            {{ old('is_active', true) ? 'checked' : '' }}
                            class="mt-1 h-4 w-4 rounded border-slate-300 text-slate-900 focus:ring-slate-400">

                        <span>
                            <span class="block text-sm font-medium text-slate-800">
                                Active Account
                            </span>

                            <span class="mt-1 block text-xs leading-5 text-slate-500">
                                Active accounts can be used when creating new transactions.
                            </span>
                        </span>

                    </label>

                    @error('is_active')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Buttons --}}
                <div class="flex flex-col-reverse gap-3 border-t border-slate-200 pt-6 sm:flex-row sm:justify-end">

                    <a href="{{ url('/accounts') }}"
                        class="inline-flex items-center justify-center rounded-xl border border-slate-300 px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                        Cancel
                    </a>

                    <button type="submit"
                        class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-400 focus:ring-offset-2">
                        Create Account
                    </button>

                </div>

            </form>

        </div>

    </div>

@endsection
