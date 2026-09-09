@extends('layouts.app')

@section('content')
    <div class="space-y-6">

        <div>
            <p class="text-sm font-medium text-indigo-600">
                Admin Panel
            </p>

            <h1 class="mt-1 text-2xl font-bold text-slate-900">
                All Accounts
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                View all accounts belonging to system users.
            </p>
        </div>

        @if (session('success'))
            <div class="rounded-lg bg-green-50 p-4 text-sm text-green-700">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="rounded-lg bg-red-50 p-4 text-sm text-red-700">
                {{ session('error') }}
            </div>
        @endif

        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

            <div class="overflow-x-auto">

                <table class="min-w-full divide-y divide-slate-200">

                    <thead class="bg-slate-50">

                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-slate-500">
                                Account
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-slate-500">
                                User
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-slate-500">
                                Type
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-slate-500">
                                Balance
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-slate-500">
                                Currency
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-slate-500">
                                Status
                            </th>
                        </tr>

                    </thead>

                    <tbody class="divide-y divide-slate-200">

                        @forelse($accounts as $account)
                            <tr class="hover:bg-slate-50">

                                <td class="px-6 py-4 text-sm font-medium text-slate-900">
                                    {{ $account->name }}
                                </td>

                                <td class="px-6 py-4">

                                    <div class="text-sm font-medium text-slate-900">
                                        {{ $account->user->name ?? 'Unknown' }}
                                    </div>

                                    <div class="text-xs text-slate-500">
                                        {{ $account->user->email ?? '' }}
                                    </div>

                                </td>

                                <td class="px-6 py-4 text-sm text-slate-600">
                                    {{ ucwords(str_replace('_', ' ', $account->type)) }}
                                </td>

                                <td class="px-6 py-4 text-sm font-semibold text-slate-900">
                                    {{ number_format($account->balance, 2) }}
                                </td>

                                <td class="px-6 py-4 text-sm text-slate-600">
                                    {{ $account->currency }}
                                </td>

                                <td class="px-6 py-4">

                                    @if ($account->is_active)
                                        <span
                                            class="rounded-full bg-green-100 px-2.5 py-1 text-xs font-medium text-green-700">
                                            Active
                                        </span>
                                    @else
                                        <span
                                            class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-600">
                                            Inactive
                                        </span>
                                    @endif

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-sm text-slate-500">
                                    No accounts found.
                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>
@endsection
