@extends('layouts.app')

@section('content')

<div class="mx-auto max-w-7xl space-y-8 py-6">

    {{-- ================= HEADER ================= --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <p class="text-sm font-medium text-indigo-600">
                Financial Accounts
            </p>

            <h1 class="mt-1 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                My Accounts
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Manage your bank accounts, wallets and cash.
            </p>
        </div>

        <a href="{{ url('/accounts/create') }}"
           class="inline-flex items-center justify-center rounded-xl
                  bg-indigo-600 px-5 py-3 text-sm font-semibold text-white
                  shadow-sm transition hover:bg-indigo-700
                  focus:outline-none focus:ring-4 focus:ring-indigo-500/20">

            <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor"
                 viewBox="0 0 24 24">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M12 4v16m8-8H4"/>

            </svg>

            Add Account
        </a>

    </div>


    {{-- ================= SUCCESS MESSAGE ================= --}}
    @if(session('success'))

        <div class="flex items-center gap-3 rounded-xl border border-green-200
                    bg-green-50 px-5 py-4 text-sm text-green-700">

            <div class="flex h-8 w-8 shrink-0 items-center justify-center
                        rounded-full bg-green-100 font-bold">
                ✓
            </div>

            <p>
                {{ session('success') }}
            </p>

        </div>

    @endif


    {{-- ================= SUMMARY ================= --}}
    <div class="grid gap-5 sm:grid-cols-3">

        {{-- Total Accounts --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

            <div class="flex items-center gap-4">

                <div class="flex h-12 w-12 items-center justify-center
                            rounded-xl bg-indigo-50 text-indigo-600">

                    <svg class="h-6 w-6" fill="none" stroke="currentColor"
                         viewBox="0 0 24 24">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M3 10h18M7 15h2m4 0h2m-8 4h10
                                 a2 2 0 002-2V7a2 2 0 00-2-2H5
                                 a2 2 0 00-2 2v10a2 2 0 002 2z"/>

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

                <div class="flex h-12 w-12 items-center justify-center
                            rounded-xl bg-green-50 text-green-600">

                    <span class="text-xl font-bold">₨</span>

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

                <div class="flex h-12 w-12 items-center justify-center
                            rounded-xl bg-blue-50 text-blue-600">

                    <svg class="h-6 w-6" fill="none" stroke="currentColor"
                         viewBox="0 0 24 24">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M5 13l4 4L19 7"/>

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
    @if($accounts->count())

        <div>

            <div class="mb-5 flex items-center justify-between">

                <div>
                    <h2 class="text-lg font-semibold text-slate-900">
                        Your Accounts
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">
                        All accounts connected to your profile.
                    </p>
                </div>

            </div>


            <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">

                @foreach($accounts as $account)

                    <div class="group overflow-hidden rounded-2xl border border-slate-200
                                bg-white shadow-sm transition
                                hover:-translate-y-1 hover:shadow-md">

                        {{-- Account Header --}}
                        <div class="border-b border-slate-100 p-6">

                            <div class="flex items-start justify-between">

                                <div class="flex items-center gap-4">

                                    {{-- Account icon --}}
                                    <div class="flex h-12 w-12 items-center justify-center
                                                rounded-xl bg-indigo-50 text-indigo-600">

                                        @if(strtolower($account->type) === 'bank')

                                            <svg class="h-6 w-6" fill="none"
                                                 stroke="currentColor"
                                                 viewBox="0 0 24 24">

                                                <path stroke-linecap="round"
                                                      stroke-linejoin="round"
                                                      stroke-width="2"
                                                      d="M3 10h18M5 10v8m4-8v8m6-8v8m4-8v8
                                                         M3 21h18M12 3l9 5H3l9-5z"/>

                                            </svg>

                                        @else

                                            <svg class="h-6 w-6" fill="none"
                                                 stroke="currentColor"
                                                 viewBox="0 0 24 24">

                                                <path stroke-linecap="round"
                                                      stroke-linejoin="round"
                                                      stroke-width="2"
                                                      d="M12 8c-1.657 0-3 1.343-3 3
                                                         s1.343 3 3 3 3 1.343 3 3
                                                         -1.343 3-3 3m0-14V5
                                                         m0 14v2m9-9a9 9 0 11-18 0
                                                         9 9 0 0118 0z"/>

                                            </svg>

                                        @endif

                                    </div>


                                    <div>

                                        <h3 class="font-semibold text-slate-900">
                                            {{ $account->name }}
                                        </h3>

                                        <p class="mt-1 text-xs capitalize text-slate-500">
                                            {{ $account->type }}
                                        </p>

                                    </div>

                                </div>


                                {{-- Status --}}
                                @if($account->is_active)

                                    <span class="rounded-full bg-green-50 px-3 py-1
                                                 text-xs font-semibold text-green-700">
                                        Active
                                    </span>

                                @else

                                    <span class="rounded-full bg-slate-100 px-3 py-1
                                                 text-xs font-semibold text-slate-500">
                                        Inactive
                                    </span>

                                @endif

                            </div>

                        </div>


                        {{-- Balance --}}
                        <div class="p-6">

                            <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                                Current Balance
                            </p>

                            <p class="mt-2 text-3xl font-bold text-slate-900">
                                {{ $account->currency }}
                                {{ number_format($account->balance, 2) }}
                            </p>


                            {{-- Actions --}}
                            <div class="mt-6 flex items-center gap-2">

                                <a href="{{ url('/accounts/' . $account->id) }}"
                                   class="flex-1 rounded-lg border border-slate-200
                                          px-3 py-2 text-center text-sm font-medium
                                          text-slate-700 transition
                                          hover:bg-slate-50">
                                    View
                                </a>

                                <a href="{{ url('/accounts/' . $account->id . '/edit') }}"
                                   class="flex-1 rounded-lg border border-indigo-200
                                          px-3 py-2 text-center text-sm font-medium
                                          text-indigo-600 transition
                                          hover:bg-indigo-50">
                                    Edit
                                </a>

                                <form
                                    method="POST"
                                    action="{{ url('/accounts/' . $account->id) }}"
                                    class="flex-1"
                                    onsubmit="return confirm('Are you sure you want to delete this account?');"
                                >

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="w-full rounded-lg border border-red-200
                                               px-3 py-2 text-sm font-medium
                                               text-red-600 transition
                                               hover:bg-red-50"
                                    >
                                        Delete
                                    </button>

                                </form>

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

            <div class="mx-auto flex h-16 w-16 items-center justify-center
                        rounded-2xl bg-indigo-50 text-indigo-600">

                <svg class="h-8 w-8" fill="none" stroke="currentColor"
                     viewBox="0 0 24 24">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M3 10h18M7 15h2m4 0h2m-8 4h10
                             a2 2 0 002-2V7a2 2 0 00-2-2H5
                             a2 2 0 00-2 2v10a2 2 0 002 2z"/>

                </svg>

            </div>


            <h2 class="mt-5 text-lg font-semibold text-slate-900">
                No accounts yet
            </h2>

            <p class="mx-auto mt-2 max-w-md text-sm text-slate-500">
                Add your first bank account, digital wallet or cash account
                to start tracking your finances.
            </p>


            <a href="{{ url('/accounts/create') }}"
               class="mt-6 inline-flex items-center rounded-xl
                      bg-indigo-600 px-5 py-3 text-sm font-semibold text-white
                      transition hover:bg-indigo-700">

                <span class="mr-2 text-lg">+</span>

                Add your first account

            </a>

        </div>

    @endif

</div>

@endsection
