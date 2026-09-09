@extends('layouts.guest')

@section('content')

    <div class="flex min-h-screen">

        {{-- ================= LEFT SIDE ================= --}}
        <div class="hidden w-1/2 bg-slate-900 lg:flex lg:flex-col lg:justify-between">

            {{-- Logo --}}
            <div class="p-10">

                <div class="flex items-center gap-3">

                    <div
                        class="flex h-11 w-11 items-center justify-center
                            rounded-xl bg-indigo-600 text-xl font-bold text-white">
                        $
                    </div>

                    <div>
                        <h1 class="text-xl font-bold text-white">
                            Finance Manager
                        </h1>

                        <p class="text-sm text-slate-400">
                            Personal Finance Management
                        </p>
                    </div>

                </div>

            </div>


            {{-- Main message --}}
            <div class="px-10">

                <div class="max-w-lg">

                    <h2 class="text-4xl font-bold leading-tight text-white">
                        Start managing your
                        <span class="text-indigo-400">
                            money smarter.
                        </span>
                    </h2>

                    <p class="mt-6 text-lg leading-relaxed text-slate-400">
                        Create your account and start tracking your
                        income, expenses, accounts and financial goals.
                    </p>


                    {{-- Features --}}
                    <div class="mt-10 space-y-5">

                        <div class="flex items-center gap-4">

                            <div
                                class="flex h-10 w-10 items-center justify-center
                                    rounded-lg bg-slate-800 text-indigo-400">

                                ✓

                            </div>

                            <div>
                                <p class="font-medium text-white">
                                    Track your transactions
                                </p>

                                <p class="text-sm text-slate-500">
                                    Keep your income and expenses organized.
                                </p>
                            </div>

                        </div>


                        <div class="flex items-center gap-4">

                            <div
                                class="flex h-10 w-10 items-center justify-center
                                    rounded-lg bg-slate-800 text-indigo-400">

                                ✓

                            </div>

                            <div>
                                <p class="font-medium text-white">
                                    Manage multiple accounts
                                </p>

                                <p class="text-sm text-slate-500">
                                    Banks, cash wallets and digital wallets.
                                </p>
                            </div>

                        </div>


                        <div class="flex items-center gap-4">

                            <div
                                class="flex h-10 w-10 items-center justify-center
                                    rounded-lg bg-slate-800 text-indigo-400">

                                ✓

                            </div>

                            <div>
                                <p class="font-medium text-white">
                                    Understand your spending
                                </p>

                                <p class="text-sm text-slate-500">
                                    Organize expenses with categories.
                                </p>
                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- Footer --}}
            <div class="p-10">

                <p class="text-sm text-slate-500">
                    © {{ date('Y') }} Finance Manager.
                </p>

            </div>

        </div>


        {{-- ================= RIGHT SIDE ================= --}}
        <div class="flex w-full items-center justify-center px-6 py-10 lg:w-1/2">

            <div class="w-full max-w-md">

                {{-- Mobile Logo --}}
                <div class="mb-8 flex flex-col items-center lg:hidden">

                    <div
                        class="flex h-14 w-14 items-center justify-center
                            rounded-2xl bg-indigo-600 text-2xl font-bold text-white">
                        $
                    </div>

                    <h1 class="mt-4 text-xl font-bold text-slate-900">
                        Finance Manager
                    </h1>

                    <p class="mt-1 text-sm text-slate-500">
                        Personal Finance Management
                    </p>

                </div>


                {{-- Heading --}}
                <div class="mb-8">

                    <h2 class="text-3xl font-bold tracking-tight text-slate-900">
                        Create your account
                    </h2>

                    <p class="mt-2 text-sm text-slate-500">
                        Get started with your personal finance manager.
                    </p>

                </div>


                {{-- Validation errors --}}
                @if ($errors->any())
                    <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4">

                        <p class="text-sm font-semibold text-red-800">
                            Please fix the following errors:
                        </p>

                        <ul class="mt-2 list-inside list-disc space-y-1 text-sm text-red-600">

                            @foreach ($errors->all() as $error)
                                <li>
                                    {{ $error }}
                                </li>
                            @endforeach

                        </ul>

                    </div>
                @endif


                {{-- Registration form --}}
                <form method="POST" action="{{ url('/register') }}" class="space-y-5">

                    @csrf


                    {{-- Name --}}
                    <div>

                        <label for="name" class="mb-2 block text-sm font-semibold text-slate-700">
                            Full name
                        </label>

                        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                            autocomplete="name" placeholder="John Doe"
                            class="w-full rounded-xl border border-slate-300 bg-white
                               px-4 py-3 text-sm text-slate-900 outline-none
                               transition placeholder:text-slate-400
                               focus:border-indigo-500
                               focus:ring-4 focus:ring-indigo-500/10">

                        @error('name')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- Email --}}
                    <div>

                        <label for="email" class="mb-2 block text-sm font-semibold text-slate-700">
                            Email address
                        </label>

                        <input id="email" type="email" name="email" value="{{ old('email') }}" required
                            autocomplete="email" placeholder="you@example.com"
                            class="w-full rounded-xl border border-slate-300 bg-white
                               px-4 py-3 text-sm text-slate-900 outline-none
                               transition placeholder:text-slate-400
                               focus:border-indigo-500
                               focus:ring-4 focus:ring-indigo-500/10">

                        @error('email')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- Password --}}
                    <div>

                        <label for="password" class="mb-2 block text-sm font-semibold text-slate-700">
                            Password
                        </label>

                        <input id="password" type="password" name="password" required autocomplete="new-password"
                            placeholder="Create a strong password"
                            class="w-full rounded-xl border border-slate-300 bg-white
                               px-4 py-3 text-sm text-slate-900 outline-none
                               transition placeholder:text-slate-400
                               focus:border-indigo-500
                               focus:ring-4 focus:ring-indigo-500/10">

                        @error('password')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- Confirm password --}}
                    <div>

                        <label for="password_confirmation" class="mb-2 block text-sm font-semibold text-slate-700">
                            Confirm password
                        </label>

                        <input id="password_confirmation" type="password" name="password_confirmation" required
                            autocomplete="new-password" placeholder="Confirm your password"
                            class="w-full rounded-xl border border-slate-300 bg-white
                               px-4 py-3 text-sm text-slate-900 outline-none
                               transition placeholder:text-slate-400
                               focus:border-indigo-500
                               focus:ring-4 focus:ring-indigo-500/10">

                    </div>


                    {{-- Terms --}}
                    <div class="flex items-start gap-3 pt-1">

                        <input id="terms" type="checkbox" required
                            class="mt-1 h-4 w-4 rounded border-slate-300
                               text-indigo-600 focus:ring-indigo-500">

                        <label for="terms" class="text-sm leading-5 text-slate-500">
                            I agree to the
                            <a href="#" class="font-medium text-indigo-600 hover:text-indigo-700">
                                terms and conditions
                            </a>.
                        </label>

                    </div>


                    {{-- Submit --}}
                    <button type="submit"
                        class="flex w-full items-center justify-center
                           rounded-xl bg-indigo-600 px-4 py-3.5
                           text-sm font-semibold text-white shadow-sm
                           transition hover:bg-indigo-700
                           focus:outline-none
                           focus:ring-4 focus:ring-indigo-500/20
                           active:scale-[0.99]">
                        Create account
                    </button>

                </form>


                {{-- Login link --}}
                <div class="mt-8 text-center">

                    <p class="text-sm text-slate-500">

                        Already have an account?

                        <a href="{{ url('/login') }}" class="font-semibold text-indigo-600 hover:text-indigo-700">
                            Sign in
                        </a>

                    </p>

                </div>

            </div>

        </div>

    </div>

@endsection
