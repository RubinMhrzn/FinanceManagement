@extends('layouts.app')

@section('content')

    <div class="mx-auto max-w-3xl space-y-8 py-6">

        {{-- Header --}}
        <div>

            <div class="flex items-center gap-2 text-sm text-slate-500">

                <a href="{{ request()->routeIs('admin.categories.*') ? route('admin.categories.index') : route('categories.index') }}"
                    class="hover:text-slate-800">
                    Categories
                </a>

                <span>/</span>

                <span class="text-slate-700">
                    Edit
                </span>

            </div>

            <div class="mt-3">

                <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                    Edit Category
                </h1>

                <p class="mt-1 text-sm text-slate-500 sm:text-base">
                    Update the information for {{ $category->name }}.
                </p>

            </div>

        </div>


        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="rounded-xl border border-red-200 bg-red-50 p-4">

                <h3 class="font-semibold text-red-800">
                    Please fix the following errors:
                </h3>

                <ul class="mt-2 list-inside list-disc space-y-1 text-sm text-red-700">

                    @foreach ($errors->all() as $error)
                        <li>
                            {{ $error }}
                        </li>
                    @endforeach

                </ul>

            </div>
        @endif


        {{-- Form Card --}}
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

            {{-- Card Header --}}
            <div class="border-b border-slate-200 px-5 py-5 sm:px-7">

                <h2 class="text-lg font-semibold text-slate-900">
                    Category Information
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Modify the category details below.
                </p>

            </div>


            {{-- Form --}}

            <form
                action="{{ request()->routeIs('admin.categories.*')
                    ? route('admin.categories.update', $category)
                    : route('categories.update', $category) }}"
                method="POST" class="space-y-6 p-5 sm:p-7">

                @csrf

                @method('PUT')


                {{-- Admin Only: User --}}

                @if (request()->routeIs('admin.categories.*'))
                    <div>

                        <label for="user_id" class="mb-2 block text-sm font-medium text-slate-700">
                            Category Owner
                            <span class="text-red-500">*</span>
                        </label>

                        <select name="user_id" id="user_id"
                            class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-slate-500 focus:ring-2 focus:ring-slate-200">

                            {{-- Global Category --}}

                            <option value="">
                                Global Category
                            </option>


                            {{-- Users --}}

                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" @selected(old('user_id', $category->user_id) == $user->id)>
                                    {{ $user->name }} — {{ $user->email }}
                                </option>
                            @endforeach

                        </select>

                        <p class="mt-2 text-xs text-slate-500">
                            Select a user or choose Global Category.
                        </p>

                        @error('user_id')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>
                @endif


                {{-- Name --}}

                <div>

                    <label for="name" class="mb-2 block text-sm font-medium text-slate-700">
                        Category Name

                        <span class="text-red-500">*</span>
                    </label>

                    <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}"
                        placeholder="e.g. Food, Salary, Transport"
                        class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-slate-500 focus:ring-2 focus:ring-slate-200">

                    @error('name')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Type --}}

                <div>

                    <label class="mb-3 block text-sm font-medium text-slate-700">

                        Category Type

                        <span class="text-red-500">*</span>

                    </label>


                    <div class="grid gap-4 sm:grid-cols-2">


                        {{-- Income --}}

                        <label class="cursor-pointer">

                            <input type="radio" name="type" value="income" class="peer sr-only"
                                {{ old('type', $category->type) === 'income' ? 'checked' : '' }}>

                            <div
                                class="rounded-2xl border-2 border-slate-200 p-5 transition hover:border-slate-300 peer-checked:border-emerald-500 peer-checked:bg-emerald-50">

                                <div class="flex items-start gap-4">

                                    <div
                                        class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-emerald-100 text-xl font-bold text-emerald-600">
                                        ↑
                                    </div>

                                    <div>

                                        <p class="font-semibold text-slate-900">
                                            Income
                                        </p>

                                        <p class="mt-1 text-sm text-slate-500">
                                            Money coming into the account.
                                        </p>

                                        <p class="mt-2 text-xs font-medium text-emerald-600">
                                            Salary, Freelancing, Bonus
                                        </p>

                                    </div>

                                </div>

                            </div>

                        </label>


                        {{-- Expense --}}

                        <label class="cursor-pointer">

                            <input type="radio" name="type" value="expense" class="peer sr-only"
                                {{ old('type', $category->type) === 'expense' ? 'checked' : '' }}>

                            <div
                                class="rounded-2xl border-2 border-slate-200 p-5 transition hover:border-slate-300 peer-checked:border-red-500 peer-checked:bg-red-50">

                                <div class="flex items-start gap-4">

                                    <div
                                        class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-red-100 text-xl font-bold text-red-600">
                                        ↓
                                    </div>

                                    <div>

                                        <p class="font-semibold text-slate-900">
                                            Expense
                                        </p>

                                        <p class="mt-1 text-sm text-slate-500">
                                            Money going out of the account.
                                        </p>

                                        <p class="mt-2 text-xs font-medium text-red-600">
                                            Food, Rent, Transport
                                        </p>

                                    </div>

                                </div>

                            </div>

                        </label>

                    </div>


                    @error('type')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Active --}}

                <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">

                    <label class="flex cursor-pointer items-start gap-3">

                        <input type="checkbox" name="is_active" value="1"
                            {{ old('is_active', $category->is_active) ? 'checked' : '' }}
                            class="mt-1 h-4 w-4 rounded border-slate-300 text-slate-900 focus:ring-slate-400">

                        <span>

                            <span class="block text-sm font-medium text-slate-800">
                                Active Category
                            </span>

                            <span class="mt-1 block text-xs leading-5 text-slate-500">
                                Active categories can be selected when creating transactions.
                            </span>

                        </span>

                    </label>

                </div>


                {{-- Buttons --}}

                <div class="flex flex-col-reverse gap-3 border-t border-slate-200 pt-6 sm:flex-row sm:justify-end">

                    <a href="{{ request()->routeIs('admin.categories.*') ? route('admin.categories.index') : route('categories.index') }}"
                        class="inline-flex items-center justify-center rounded-xl border border-slate-300 px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                        Cancel
                    </a>


                    <button type="submit"
                        class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-400 focus:ring-offset-2">
                        Update Category
                    </button>

                </div>

            </form>

        </div>

    </div>

@endsection
