@extends('layouts.app')

@section('content')

    <div class="mx-auto max-w-3xl py-6">

        <div class="mb-8">

            <a href="{{ url('/admin/roles') }}" class="text-sm text-slate-500 hover:text-slate-900">
                ← Back to Roles
            </a>

            <h1 class="mt-3 text-2xl font-bold text-slate-900 sm:text-3xl">
                Edit Role
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Update role information and permissions.
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

            <form action="{{ url('/admin/roles/' . $role->id) }}" method="POST" class="space-y-6 p-6 sm:p-8">

                @csrf
                @method('PUT')


                <div>
                    <label for="name" class="mb-2 block text-sm font-medium text-slate-700">
                        Role Name
                    </label>

                    <input type="text" name="name" id="name" value="{{ old('name', $role->name) }}" required
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-slate-500 focus:ring-2 focus:ring-slate-200">
                </div>


                <div>
                    <label for="description" class="mb-2 block text-sm font-medium text-slate-700">
                        Description
                    </label>

                    <textarea name="description" id="description" rows="4"
                        class="w-full resize-none rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-slate-500 focus:ring-2 focus:ring-slate-200">{{ old('description', $role->description) }}</textarea>
                </div>


                {{-- Permissions --}}
                <div>

                    <label class="mb-3 block text-sm font-medium text-slate-700">
                        Permissions
                    </label>

                    @php
                        $selectedPermissions = old('permissions', $role->permissions->pluck('id')->toArray());
                    @endphp

                    <div class="grid gap-3 sm:grid-cols-2">

                        @foreach ($permissions as $permission)
                            <label
                                class="flex cursor-pointer items-start gap-3 rounded-xl border border-slate-200 p-4 hover:bg-slate-50">

                                <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                                    class="mt-1 rounded border-slate-300"
                                    {{ in_array($permission->id, $selectedPermissions) ? 'checked' : '' }}>

                                <div>

                                    <p class="text-sm font-semibold text-slate-900">
                                        {{ $permission->name }}
                                    </p>

                                    <p class="mt-1 text-xs text-slate-500">
                                        {{ $permission->description }}
                                    </p>

                                </div>

                            </label>
                        @endforeach

                    </div>

                </div>


                <div class="flex flex-col-reverse gap-3 border-t border-slate-200 pt-6 sm:flex-row sm:justify-end">

                    <a href="{{ url('/admin/roles') }}"
                        class="rounded-xl border border-slate-300 px-5 py-3 text-center text-sm font-semibold text-slate-700 hover:bg-slate-50">
                        Cancel
                    </a>

                    <button type="submit"
                        class="rounded-xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white hover:bg-slate-800">
                        Update Role
                    </button>

                </div>

            </form>

        </div>

    </div>

@endsection
