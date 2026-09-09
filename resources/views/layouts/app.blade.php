<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title ?? 'Finance Manager' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>


<body class="min-h-screen bg-slate-100 text-slate-800">


    {{-- ========================================================= --}}
    {{-- DESKTOP SIDEBAR --}}
    {{-- ========================================================= --}}

    <aside class="fixed inset-y-0 left-0 z-40 hidden w-64 flex-col border-r border-slate-200 bg-white lg:flex">

        {{-- ===================================================== --}}
        {{-- LOGO --}}
        {{-- ===================================================== --}}

        <div class="flex h-20 items-center border-b border-slate-200 px-6">

            @if (auth()->user()->role?->name === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                @elseif (auth()->user()->role?->name === 'manager')
                    <a href="{{ route('manager.dashboard') }}" class="flex items-center gap-3">
                    @else
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
            @endif

            {{-- Logo Icon --}}
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-600 text-white">

                <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">

                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2
                            3 .895 3 2-1.343 2-3 2m0-8
                            c1.11 0 2.08.402 2.599 1M12 8V6
                            m0 12v-2m0 2c-1.11 0-2.08-.402-2.599-1
                            M12 18c1.657 0 3-.895 3-2s-1.343-2-3-2" />

                </svg>

            </div>


            {{-- Logo Text --}}
            <div>

                <h1 class="text-lg font-bold text-slate-900">
                    Finance
                </h1>

                <p class="text-xs text-slate-500">
                    {{ ucfirst(auth()->user()->role?->name ?? 'User') }}
                </p>

            </div>

            </a>

        </div>


        {{-- ========================================================= --}}
        {{-- SIDEBAR NAVIGATION --}}
        {{-- ========================================================= --}}

        <nav class="flex-1 space-y-1 overflow-y-auto px-4 py-6">

            @auth

                {{-- ================================================= --}}
                {{-- USER NAVIGATION --}}
                {{-- ================================================= --}}

                @if (auth()->user()->role?->name === 'user')
                    <p class="mb-3 px-3 text-xs font-semibold uppercase tracking-wider text-slate-500">
                        Main
                    </p>


                    {{-- Dashboard --}}
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition
                        {{ request()->routeIs('dashboard')
                            ? 'bg-indigo-50 text-indigo-700'
                            : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">

                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">

                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l9-9 9 9M5 10v10h14V10" />

                        </svg>

                        Dashboard

                    </a>


                    {{-- Accounts --}}
                    <a href="{{ route('accounts.index') }}"
                        class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition
                        {{ request()->routeIs('accounts.*')
                            ? 'bg-indigo-50 text-indigo-700'
                            : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">

                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">

                            <rect x="3" y="5" width="18" height="14" rx="2" />

                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18" />

                        </svg>

                        Accounts

                    </a>


                    {{-- Categories --}}
                    <a href="{{ route('categories.index') }}"
                        class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition
                        {{ request()->routeIs('categories.*')
                            ? 'bg-indigo-50 text-indigo-700'
                            : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">

                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">

                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />

                        </svg>

                        Categories

                    </a>


                    {{-- Transactions --}}
                    <a href="{{ route('transactions.index') }}"
                        class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition
                        {{ request()->routeIs('transactions.*')
                            ? 'bg-indigo-50 text-indigo-700'
                            : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">

                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">

                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />

                        </svg>

                        Transactions

                    </a>


                    {{-- ================================================= --}}
                    {{-- MANAGER NAVIGATION --}}
                    {{-- ================================================= --}}
                @elseif (auth()->user()->role?->name === 'manager')
                    <p class="mb-3 px-3 text-xs font-semibold uppercase tracking-wider text-slate-500">
                        Management
                    </p>


                    {{-- Manager Dashboard --}}
                    <a href="{{ route('manager.dashboard') }}"
                        class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition
                        {{ request()->routeIs('manager.dashboard')
                            ? 'bg-indigo-50 text-indigo-700'
                            : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">

                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">

                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l9-9 9 9M5 10v10h14V10" />

                        </svg>

                        Dashboard

                    </a>


                    {{-- All Accounts --}}
                    <a href="{{ route('manager.accounts.index') }}"
                        class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition
                        {{ request()->routeIs('manager.accounts.*')
                            ? 'bg-indigo-50 text-indigo-700'
                            : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">

                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">

                            <rect x="3" y="5" width="18" height="14" rx="2" />

                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18" />

                        </svg>

                        All Accounts

                    </a>


                    {{-- Pending Transactions --}}
                    <a href="{{ route('manager.transactions.index') }}"
                        class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition
                        {{ request()->routeIs('manager.transactions.*')
                            ? 'bg-indigo-50 text-indigo-700'
                            : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">

                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">

                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0
                                    9 9 0 0118 0z" />

                        </svg>

                        Pending Transactions

                    </a>


                    {{-- ================================================= --}}
                    {{-- ADMIN NAVIGATION --}}
                    {{-- ================================================= --}}
                @elseif (auth()->user()->role?->name === 'admin')
                    <p class="mb-3 px-3 text-xs font-semibold uppercase tracking-wider text-slate-500">
                        Administration
                    </p>


                    {{-- Admin Dashboard --}}
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition
                        {{ request()->routeIs('admin.dashboard')
                            ? 'bg-indigo-50 text-indigo-700'
                            : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">

                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">

                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l9-9 9 9M5 10v10h14V10" />

                        </svg>

                        Admin Dashboard

                    </a>


                    {{-- Users --}}
                    <a href="{{ route('admin.users.index') }}"
                        class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition
                        {{ request()->routeIs('admin.users.*')
                            ? 'bg-indigo-50 text-indigo-700'
                            : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">

                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">

                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2" />

                            <circle cx="9" cy="7" r="4" />

                            <path stroke-linecap="round" stroke-linejoin="round" d="M22 21v-2a4 4 0 00-3-3.87
                                    M16 3.13a4 4 0 010 7.75" />

                        </svg>

                        Users

                    </a>


                    {{-- Roles --}}
                    <a href="{{ route('admin.roles.index') }}"
                        class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition
                        {{ request()->routeIs('admin.roles.*')
                            ? 'bg-indigo-50 text-indigo-700'
                            : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">

                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">

                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15l-3.5 2 1-4-3-2.5
                                    4-.2L12 6l1.5 4.3 4 .2-3 2.5 1 4z" />

                        </svg>

                        Roles

                    </a>


                    {{-- Accounts --}}
                    <a href="{{ route('admin.accounts.index') }}"
                        class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition
                        {{ request()->routeIs('admin.accounts.*')
                            ? 'bg-indigo-50 text-indigo-700'
                            : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">

                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">

                            <rect x="3" y="5" width="18" height="14" rx="2" />

                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18" />

                        </svg>

                        Accounts

                    </a>


                    {{-- Categories --}}
                    <a href="{{ route('admin.categories.index') }}"
                        class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition
                        {{ request()->routeIs('admin.categories.*')
                            ? 'bg-indigo-50 text-indigo-700'
                            : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">

                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">

                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />

                        </svg>

                        Categories

                    </a>


                    {{-- Transactions --}}
                    <a href="{{ route('admin.transactions.index') }}"
                        class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition
                        {{ request()->routeIs('admin.transactions.*')
                            ? 'bg-indigo-50 text-indigo-700'
                            : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">

                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">

                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />

                        </svg>

                        Transactions

                    </a>
                @endif

            @endauth

        </nav>


        {{-- ========================================================= --}}
        {{-- USER INFORMATION + LOGOUT --}}
        {{-- ========================================================= --}}

        @auth

            <div class="border-t border-slate-200 p-4">

                <div class="mb-3 flex items-center gap-3">

                    {{-- User Avatar --}}
                    <div
                        class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full
                        bg-indigo-100 font-semibold text-indigo-700">

                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}

                    </div>


                    {{-- User Information --}}
                    <div class="min-w-0">

                        <p class="truncate text-sm font-semibold text-slate-900">
                            {{ auth()->user()->name }}
                        </p>

                        <p class="truncate text-xs text-slate-500">
                            {{ ucfirst(auth()->user()->role?->name ?? 'User') }}
                        </p>

                    </div>

                </div>


                {{-- Logout --}}
                <form method="POST" action="{{ route('logout') }}">

                    @csrf

                    <button type="submit"
                        class="flex w-full items-center gap-3 rounded-lg px-3 py-2.5
                        text-sm font-medium text-slate-600 transition
                        hover:bg-red-50 hover:text-red-600">

                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">

                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12H3m0 0l4-4m-4 4l4 4
                                    M21 5v14a2 2 0 01-2 2h-6" />

                        </svg>

                        Logout

                    </button>

                </form>

            </div>

        @endauth

    </aside>



    {{-- ========================================================= --}}
    {{-- MOBILE HEADER --}}
    {{-- ========================================================= --}}

    <header class="sticky top-0 z-30 border-b border-slate-200 bg-white lg:hidden">

        <div class="flex h-16 items-center justify-between px-4">

            {{-- Mobile Logo --}}

            @if (auth()->user()->role?->name === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
                @elseif (auth()->user()->role?->name === 'manager')
                    <a href="{{ route('manager.dashboard') }}" class="flex items-center gap-2">
                    @else
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
            @endif

            <div
                class="flex h-9 w-9 items-center justify-center rounded-lg
                    bg-indigo-600 text-white">

                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">

                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2
                            3 2 3 .895 3 2-1.343 2-3 2" />

                </svg>

            </div>

            <span class="font-bold text-slate-900">
                Finance Manager
            </span>

            </a>


            {{-- Mobile Menu Button --}}
            <button type="button" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')"
                class="rounded-lg p-2 text-slate-600 hover:bg-slate-100">

                <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">

                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />

                </svg>

            </button>

        </div>


        {{-- ===================================================== --}}
        {{-- MOBILE NAVIGATION --}}
        {{-- ===================================================== --}}

        <div id="mobile-menu" class="hidden border-t border-slate-200 bg-white">

            <nav class="space-y-1 p-4">

                @auth

                    {{-- ================================================= --}}
                    {{-- USER --}}
                    {{-- ================================================= --}}

                    @if (auth()->user()->role?->name === 'user')
                        {{-- Dashboard --}}
                        <a href="{{ route('dashboard') }}"
                            class="block rounded-lg px-3 py-2.5 text-sm font-medium
                            {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50' }}">

                            Dashboard

                        </a>


                        {{-- Accounts --}}
                        <a href="{{ route('accounts.index') }}"
                            class="block rounded-lg px-3 py-2.5 text-sm font-medium
                            {{ request()->routeIs('accounts.*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50' }}">

                            Accounts

                        </a>


                        {{-- Categories --}}
                        <a href="{{ route('categories.index') }}"
                            class="block rounded-lg px-3 py-2.5 text-sm font-medium
                            {{ request()->routeIs('categories.*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50' }}">

                            Categories

                        </a>


                        {{-- Transactions --}}
                        <a href="{{ route('transactions.index') }}"
                            class="block rounded-lg px-3 py-2.5 text-sm font-medium
                            {{ request()->routeIs('transactions.*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50' }}">

                            Transactions

                        </a>


                        {{-- ================================================= --}}
                        {{-- MANAGER --}}
                        {{-- ================================================= --}}
                    @elseif (auth()->user()->role?->name === 'manager')
                        {{-- Dashboard --}}
                        <a href="{{ route('manager.dashboard') }}"
                            class="block rounded-lg px-3 py-2.5 text-sm font-medium
                            {{ request()->routeIs('manager.dashboard')
                                ? 'bg-indigo-50 text-indigo-700'
                                : 'text-slate-600 hover:bg-slate-50' }}">

                            Dashboard

                        </a>


                        {{-- All Accounts --}}
                        <a href="{{ route('manager.accounts.index') }}"
                            class="block rounded-lg px-3 py-2.5 text-sm font-medium
                            {{ request()->routeIs('manager.accounts.*')
                                ? 'bg-indigo-50 text-indigo-700'
                                : 'text-slate-600 hover:bg-slate-50' }}">

                            All Accounts

                        </a>


                        {{-- Pending Transactions --}}
                        <a href="{{ route('manager.transactions.index') }}"
                            class="block rounded-lg px-3 py-2.5 text-sm font-medium
                            {{ request()->routeIs('manager.transactions.*')
                                ? 'bg-indigo-50 text-indigo-700'
                                : 'text-slate-600 hover:bg-slate-50' }}">

                            Pending Transactions

                        </a>


                        {{-- ================================================= --}}
                        {{-- ADMIN --}}
                        {{-- ================================================= --}}
                    @elseif (auth()->user()->role?->name === 'admin')
                        {{-- Dashboard --}}
                        <a href="{{ route('admin.dashboard') }}"
                            class="block rounded-lg px-3 py-2.5 text-sm font-medium
                            {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50' }}">

                            Admin Dashboard

                        </a>


                        {{-- Users --}}
                        <a href="{{ route('admin.users.index') }}"
                            class="block rounded-lg px-3 py-2.5 text-sm font-medium
                            {{ request()->routeIs('admin.users.*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50' }}">

                            Users

                        </a>


                        {{-- Roles --}}
                        <a href="{{ route('admin.roles.index') }}"
                            class="block rounded-lg px-3 py-2.5 text-sm font-medium
                            {{ request()->routeIs('admin.roles.*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50' }}">

                            Roles

                        </a>


                        {{-- Accounts --}}
                        <a href="{{ route('admin.accounts.index') }}"
                            class="block rounded-lg px-3 py-2.5 text-sm font-medium
                            {{ request()->routeIs('admin.accounts.*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50' }}">

                            Accounts

                        </a>


                        {{-- Categories --}}
                        <a href="{{ route('admin.categories.index') }}"
                            class="block rounded-lg px-3 py-2.5 text-sm font-medium
                            {{ request()->routeIs('admin.categories.*')
                                ? 'bg-indigo-50 text-indigo-700'
                                : 'text-slate-600 hover:bg-slate-50' }}">

                            Categories

                        </a>


                        {{-- Transactions --}}
                        <a href="{{ route('admin.transactions.index') }}"
                            class="block rounded-lg px-3 py-2.5 text-sm font-medium
                            {{ request()->routeIs('admin.transactions.*')
                                ? 'bg-indigo-50 text-indigo-700'
                                : 'text-slate-600 hover:bg-slate-50' }}">

                            Transactions

                        </a>
                    @endif


                    {{-- ================================================= --}}
                    {{-- MOBILE LOGOUT --}}
                    {{-- ================================================= --}}

                    <div class="mt-4 border-t border-slate-200 pt-4">

                        <form method="POST" action="{{ route('logout') }}">

                            @csrf

                            <button type="submit"
                                class="w-full rounded-lg px-3 py-2.5 text-left
                                text-sm font-medium text-red-600 hover:bg-red-50">

                                Logout

                            </button>

                        </form>

                    </div>

                @endauth

            </nav>

        </div>

    </header>



    {{-- ========================================================= --}}
    {{-- MAIN CONTENT --}}
    {{-- ========================================================= --}}

    <main class="lg:ml-64">

        {{-- ===================================================== --}}
        {{-- FLASH MESSAGES --}}
        {{-- ===================================================== --}}

        <div class="px-4 pt-6 sm:px-6 lg:px-8">

            {{-- Success Message --}}
            @if (session('success'))
                <div
                    class="mb-4 flex items-center rounded-lg border border-green-200
                    bg-green-50 px-4 py-3 text-sm text-green-800">

                    <svg class="mr-3 h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">

                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />

                    </svg>

                    {{ session('success') }}

                </div>
            @endif


            {{-- Error Message --}}
            @if (session('error'))
                <div
                    class="mb-4 flex items-center rounded-lg border border-red-200
                    bg-red-50 px-4 py-3 text-sm text-red-800">

                    <svg class="mr-3 h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">

                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />

                    </svg>

                    {{ session('error') }}

                </div>
            @endif


            {{-- Validation Errors --}}
            @if ($errors->any())

                <div
                    class="mb-4 rounded-lg border border-red-200
                    bg-red-50 px-4 py-3 text-sm text-red-800">

                    <p class="mb-2 font-semibold">
                        Please fix the following errors:
                    </p>

                    <ul class="list-inside list-disc space-y-1">

                        @foreach ($errors->all() as $error)
                            <li>
                                {{ $error }}
                            </li>
                        @endforeach

                    </ul>

                </div>

            @endif

        </div>


        {{-- ===================================================== --}}
        {{-- PAGE CONTENT --}}
        {{-- ===================================================== --}}

        <div class="px-4 pb-8 sm:px-6 lg:px-8">

            @yield('content')

        </div>

    </main>


</body>

</html>
