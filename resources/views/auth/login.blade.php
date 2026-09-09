{{-- resources/views/auth/login.blade.php --}}

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login - Finance Manager</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-50">

    <div class="flex min-h-screen">

        {{-- ============================================================
            LEFT SIDE
        ============================================================ --}}

        <div class="hidden w-1/2 bg-slate-900 lg:flex lg:flex-col lg:justify-between">

            {{-- Logo --}}
            <div class="p-10">

                <div class="flex items-center gap-3">

                    <div
                        class="flex h-11 w-11 items-center justify-center rounded-xl bg-indigo-600 text-xl font-bold text-white">
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


            {{-- Center Content --}}
            <div class="px-10">

                <div class="max-w-lg">

                    <h2 class="text-4xl font-bold leading-tight text-white">

                        Take control of

                        <span class="text-indigo-400">
                            your finances.
                        </span>

                    </h2>

                    <p class="mt-6 text-lg leading-relaxed text-slate-400">

                        Track your accounts, manage transactions,
                        monitor your spending and understand your
                        financial habits in one place.

                    </p>

                </div>

            </div>


            {{-- Bottom --}}
            <div class="p-10">

                <p class="text-sm text-slate-500">

                    © {{ date('Y') }} Finance Manager.
                    All rights reserved.

                </p>

            </div>

        </div>


        {{-- ============================================================
            RIGHT SIDE
        ============================================================ --}}

        <div class="flex w-full items-center justify-center px-6 py-12 lg:w-1/2">

            <div class="w-full max-w-md">


                {{-- ====================================================
                    MOBILE LOGO
                ==================================================== --}}

                <div class="mb-10 flex flex-col items-center lg:hidden">

                    <div
                        class="flex h-14 w-14 items-center justify-center rounded-2xl bg-indigo-600 text-2xl font-bold text-white">
                        $
                    </div>

                    <h1 class="mt-4 text-xl font-bold text-slate-900">
                        Finance Manager
                    </h1>

                    <p class="mt-1 text-sm text-slate-500">
                        Personal Finance Management
                    </p>

                </div>


                {{-- ====================================================
                    HEADING
                ==================================================== --}}

                <div class="mb-8">

                    <h2 class="text-3xl font-bold tracking-tight text-slate-900">
                        Welcome back
                    </h2>

                    <p class="mt-2 text-sm text-slate-500">
                        Sign in to access your finance dashboard.
                    </p>

                </div>


                {{-- ====================================================
                    ERROR MESSAGE
                ==================================================== --}}

                @if ($errors->any())

                    <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4">

                        <div class="flex gap-3">

                            <svg class="mt-0.5 h-5 w-5 shrink-0 text-red-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M10.29 3.86l-7.82 14a2 2 0 001.74 3h15.58a2 2 0 001.74-3l-7.82-14a2 2 0 00-3.42 0z" />

                            </svg>

                            <div>

                                <p class="text-sm font-semibold text-red-800">
                                    Unable to sign in
                                </p>

                                <ul class="mt-1 text-sm text-red-600">

                                    @foreach ($errors->all() as $error)
                                        <li>
                                            {{ $error }}
                                        </li>
                                    @endforeach

                                </ul>

                            </div>

                        </div>

                    </div>

                @endif


                {{-- ====================================================
                    SUCCESS MESSAGE
                ==================================================== --}}

                @if (session('success'))
                    <div class="mb-6 rounded-xl border border-green-200 bg-green-50 p-4">

                        <p class="text-sm font-medium text-green-700">
                            {{ session('success') }}
                        </p>

                    </div>
                @endif


                {{-- ====================================================
                    LOGIN FORM
                ==================================================== --}}

                <form method="POST" action="{{ route('login') }}" class="space-y-6">

                    @csrf


                    {{-- ==================================================
                        EMAIL
                    ================================================== --}}

                    <div>

                        <label for="email" class="mb-2 block text-sm font-semibold text-slate-700">

                            Email address

                        </label>

                        <input id="email" type="email" name="email" value="{{ old('email') }}" required
                            autofocus autocomplete="email" placeholder="you@example.com"
                            class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3
                                   text-sm text-slate-900 outline-none transition
                                   placeholder:text-slate-400
                                   focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10">

                        @error('email')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- ==================================================
                        PASSWORD
                    ================================================== --}}

                    <div>

                        <label for="password" class="mb-2 block text-sm font-semibold text-slate-700">

                            Password

                        </label>

                        <input id="password" type="password" name="password" required autocomplete="current-password"
                            placeholder="Enter your password"
                            class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3
                                   text-sm text-slate-900 outline-none transition
                                   placeholder:text-slate-400
                                   focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10">

                        @error('password')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- ==================================================
                        REMEMBER ME
                    ================================================== --}}

                    <div class="flex items-center">

                        <label class="flex cursor-pointer items-center gap-3">

                            <input type="checkbox" name="remember" value="1"
                                class="h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">

                            <span class="text-sm text-slate-600">
                                Remember me
                            </span>

                        </label>

                    </div>


                    {{-- ==================================================
                        LOGIN BUTTON
                    ================================================== --}}

                    <button type="submit"
                        class="flex w-full items-center justify-center rounded-xl
                               bg-indigo-600 px-4 py-3.5 text-sm font-semibold text-white
                               shadow-sm transition
                               hover:bg-indigo-700
                               focus:outline-none focus:ring-4 focus:ring-indigo-500/20
                               active:scale-[0.99]">

                        Sign in

                    </button>

                </form>


                {{-- ====================================================
                    REGISTER
                ==================================================== --}}

                <div class="mt-8 text-center">

                    <p class="text-sm text-slate-500">

                        Don't have an account?

                        <a href="{{ route('register') }}" class="font-semibold text-indigo-600 hover:text-indigo-700">

                            Create an account

                        </a>

                    </p>

                </div>


                {{-- ====================================================
                    DEVELOPMENT ACCOUNTS
                ==================================================== --}}

                <div class="mt-8 rounded-xl border border-slate-200 bg-white p-4">

                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                        Development accounts
                    </p>

                    <div class="mt-3 space-y-2 text-sm">


                        {{-- Admin --}}
                        <div class="flex justify-between gap-4">

                            <span class="text-slate-500">
                                Admin
                            </span>

                            <span class="font-medium text-slate-700">
                                admin@example.com
                            </span>

                        </div>


                        {{-- Manager --}}
                        <div class="flex justify-between gap-4">

                            <span class="text-slate-500">
                                Manager
                            </span>

                            <span class="font-medium text-slate-700">
                                manager@example.com
                            </span>

                        </div>


                        {{-- User --}}
                        <div class="flex justify-between gap-4">

                            <span class="text-slate-500">
                                User
                            </span>

                            <span class="font-medium text-slate-700">
                                user@example.com
                            </span>

                        </div>


                        <p class="pt-1 text-xs text-slate-400">
                            Password: password
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>

</body>

</html>
