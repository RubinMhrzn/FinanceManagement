@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-7xl space-y-8 py-6">

        {{-- Header --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <h1 class="text-2xl font-bold text-slate-900 sm:text-3xl">
                    Users
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Manage users and their roles.
                </p>
            </div>

            <a href="{{ url('/admin/users/create') }}"
                class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white hover:bg-slate-800">
                + Add User
            </a>

        </div>


        {{-- Stats --}}
        <div class="grid gap-4 sm:grid-cols-3">

            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm text-slate-500">Total Users</p>
                <p class="mt-2 text-3xl font-bold text-slate-900">
                    {{ $users->count() }}
                </p>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm text-slate-500">Admins</p>
                <p class="mt-2 text-3xl font-bold text-slate-900">
                    {{ $users->where('role.name', 'admin')->count() }}
                </p>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm text-slate-500">Managers</p>
                <p class="mt-2 text-3xl font-bold text-slate-900">
                    {{ $users->where('role.name', 'manager')->count() }}
                </p>
            </div>

        </div>


        {{-- Desktop Table --}}
        <div class="hidden overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm md:block">

            <div class="overflow-x-auto">

                <table class="w-full text-left text-sm">

                    <thead class="border-b border-slate-200 bg-slate-50">
                        <tr>
                            <th class="px-6 py-4 font-semibold text-slate-600">
                                User
                            </th>

                            <th class="px-6 py-4 font-semibold text-slate-600">
                                Role
                            </th>

                            <th class="px-6 py-4 font-semibold text-slate-600">
                                Joined
                            </th>

                            <th class="px-6 py-4 text-right font-semibold text-slate-600">
                                Actions
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">

                        @forelse ($users as $user)
                            <tr class="hover:bg-slate-50">

                                <td class="px-6 py-4">
                                    <p class="font-semibold text-slate-900">
                                        {{ $user->name }}
                                    </p>

                                    <p class="text-slate-500">
                                        {{ $user->email }}
                                    </p>
                                </td>

                                <td class="px-6 py-4">

                                    <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">
                                        {{ ucfirst($user->role->name) }}
                                    </span>

                                </td>

                                <td class="px-6 py-4 text-slate-500">
                                    {{ $user->created_at->format('M d, Y') }}
                                </td>

                                <td class="px-6 py-4 text-right">

                                    <div class="flex justify-end gap-2">

                                        <a href="{{ url('/admin/users/' . $user->id . '/edit') }}"
                                            class="rounded-lg border border-slate-300 px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50">
                                            Edit
                                        </a>

                                        <form action="{{ url('/admin/users/' . $user->id) }}" method="POST"
                                            onsubmit="return confirm('Delete this user?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                class="rounded-lg border border-red-200 px-3 py-2 text-xs font-semibold text-red-600 hover:bg-red-50">
                                                Delete
                                            </button>
                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-slate-500">
                                    No users found.
                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>


        {{-- Mobile Cards --}}
        <div class="space-y-4 md:hidden">

            @forelse ($users as $user)
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

                    <div class="flex items-start justify-between gap-4">

                        <div>
                            <h3 class="font-semibold text-slate-900">
                                {{ $user->name }}
                            </h3>

                            <p class="mt-1 text-sm text-slate-500">
                                {{ $user->email }}
                            </p>
                        </div>

                        <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">
                            {{ ucfirst($user->role->name) }}
                        </span>

                    </div>

                    <p class="mt-4 text-xs text-slate-400">
                        Joined {{ $user->created_at->format('M d, Y') }}
                    </p>

                    <div class="mt-4 flex gap-2">

                        <a href="{{ url('/admin/users/' . $user->id . '/edit') }}"
                            class="flex-1 rounded-lg border border-slate-300 px-3 py-2 text-center text-xs font-semibold text-slate-700">
                            Edit
                        </a>

                        <form action="{{ url('/admin/users/' . $user->id) }}" method="POST" class="flex-1"
                            onsubmit="return confirm('Delete this user?')">
                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                class="w-full rounded-lg border border-red-200 px-3 py-2 text-xs font-semibold text-red-600">
                                Delete
                            </button>
                        </form>

                    </div>

                </div>

            @empty

                <div class="rounded-2xl border border-slate-200 bg-white p-10 text-center text-slate-500">
                    No users found.
                </div>
            @endforelse

        </div>

    </div>
@endsection
