@extends('layouts.app')

@section('content')

    <div class="mx-auto max-w-3xl py-6">

        <div class="mb-8">

            <a href="{{ url('/admin/users') }}" class="text-sm text-slate-500 hover:text-slate-900">
                ← Back to Users
            </a>

            <h1 class="mt-3 text-2xl font-bold text-slate-900 sm:text-3xl">
                Edit User
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Update user information and role.
            </p>

        </div>


        @if ($errors->any())
            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4">
                <ul class="list-inside list-disc text-sm text-red-700">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">

            <form action="{{ url('/admin/users/' . $user->id) }}" method="POST" class="space-y-6 p-6 sm:p-8">

                @csrf
                @method('PUT')


                {{-- Name --}}
                <div>
                    <label for="name" class="mb-2 block text-sm font-medium text-slate-700">
                        Full Name
                    </label>

                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-slate-500 focus:ring-2 focus:ring-slate-200">
                </div>


                {{-- Email --}}
                <div>
                    <label for="email" class="mb-2 block text-sm font-medium text-slate-700">
                        Email
                    </label>

                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-slate-500 focus:ring-2 focus:ring-slate-200">
                </div>


                {{-- Password --}}
                <div>
                    <label for="password" class="mb-2 block text-sm font-medium text-slate-700">
                        New Password
                    </label>

                    <input type="password" name="password" id="password"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-slate-500 focus:ring-2 focus:ring-slate-200"
                        placeholder="Leave blank to keep current password">

                    <p class="mt-2 text-xs text-slate-400">
                        Leave this field empty if you don't want to change the password.
                    </p>
                </div>


                {{-- Role --}}
                <div>
                    <label for="role_id" class="mb-2 block text-sm font-medium text-slate-700">
                        Role
                    </label>

                    <select name="role_id" id="role_id" required
                        class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm outline-none focus:border-slate-500 focus:ring-2 focus:ring-slate-200">
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}"
                                {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
                                {{ ucfirst($role->name) }}
                            </option>
                        @endforeach
                    </select>
                </div>


                {{-- Buttons --}}
                <div class="flex flex-col-reverse gap-3 border-t border-slate-200 pt-6 sm:flex-row sm:justify-end">

                    <a href="{{ url('/admin/users') }}"
                        class="rounded-xl border border-slate-300 px-5 py-3 text-center text-sm font-semibold text-slate-700 hover:bg-slate-50">
                        Cancel
                    </a>

                    <button type="submit"
                        class="rounded-xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white hover:bg-slate-800">
                        Update User
                    </button>

                </div>

            </form>

        </div>

    </div>

@endsection
