@extends('layouts.app')

@section('content')

    <div class="mx-auto max-w-6xl space-y-8 py-6">

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <h1 class="text-2xl font-bold text-slate-900 sm:text-3xl">
                    Roles
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Manage system roles and their permissions.
                </p>
            </div>

            <a href="{{ url('/admin/roles/create') }}"
                class="rounded-xl bg-slate-900 px-5 py-3 text-center text-sm font-semibold text-white hover:bg-slate-800">
                + Add Role
            </a>

        </div>


        <div class="grid gap-5 md:grid-cols-2 lg:grid-cols-3">

            @forelse ($roles as $role)
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                    <div class="flex items-start justify-between gap-4">

                        <div>
                            <h2 class="text-lg font-bold text-slate-900">
                                {{ ucfirst($role->name) }}
                            </h2>

                            <p class="mt-2 text-sm text-slate-500">
                                {{ $role->description ?: 'No description provided.' }}
                            </p>
                        </div>

                        <span class="rounded-lg bg-slate-100 px-2 py-1 text-xs font-semibold text-slate-600">
                            {{ $role->users_count ?? $role->users->count() }} users
                        </span>

                    </div>


                    <div class="mt-5">

                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                            Permissions
                        </p>

                        <div class="mt-2 flex flex-wrap gap-2">

                            @forelse ($role->permissions as $permission)
                                <span class="rounded-full bg-slate-100 px-3 py-1 text-xs text-slate-600">
                                    {{ $permission->name }}
                                </span>

                            @empty

                                <span class="text-sm text-slate-400">
                                    No permissions
                                </span>
                            @endforelse

                        </div>

                    </div>


                    <div class="mt-6 flex gap-2">

                        <a href="{{ url('/admin/roles/' . $role->id . '/edit') }}"
                            class="flex-1 rounded-xl border border-slate-300 px-4 py-2 text-center text-sm font-semibold text-slate-700 hover:bg-slate-50">
                            Edit
                        </a>

                        <form action="{{ url('/admin/roles/' . $role->id) }}" method="POST" class="flex-1"
                            onsubmit="return confirm('Delete this role?')">
                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                class="w-full rounded-xl border border-red-200 px-4 py-2 text-sm font-semibold text-red-600 hover:bg-red-50">
                                Delete
                            </button>
                        </form>

                    </div>

                </div>

            @empty

                <div
                    class="rounded-2xl border border-slate-200 bg-white p-10 text-center text-slate-500 md:col-span-2 lg:col-span-3">
                    No roles found.
                </div>
            @endforelse

        </div>

    </div>

@endsection
