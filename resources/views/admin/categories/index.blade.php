@extends('layouts.app')

@section('content')
    <div class="space-y-6">

        {{-- Header --}}

        <div class="flex items-center justify-between">

            <div>

                <p class="text-sm font-medium text-indigo-600">
                    Admin Panel
                </p>

                <h1 class="mt-1 text-2xl font-bold text-slate-900">
                    All Categories
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Manage categories for all users.
                </p>

            </div>

            <a href="{{ route('admin.categories.create') }}"
                class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">
                + Add Category
            </a>

        </div>


        {{-- Success Message --}}

        @if (session('success'))
            <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                {{ session('success') }}
            </div>
        @endif


        {{-- Error Message --}}

        @if (session('error'))
            <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                {{ session('error') }}
            </div>
        @endif


        {{-- Categories Table --}}

        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

            <div class="overflow-x-auto">

                <table class="min-w-full divide-y divide-slate-200">

                    <thead class="bg-slate-50">

                        <tr>

                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-slate-500">
                                Category
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-slate-500">
                                User
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-slate-500">
                                Type
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-slate-500">
                                Status
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-slate-500">
                                Created
                            </th>

                            <th class="px-6 py-3 text-right text-xs font-semibold uppercase text-slate-500">
                                Actions
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-slate-200">

                        @forelse($categories as $category)
                            <tr class="hover:bg-slate-50">

                                {{-- Category --}}

                                <td class="px-6 py-4">

                                    <div class="text-sm font-medium text-slate-900">
                                        {{ $category->name }}
                                    </div>

                                </td>


                                {{-- User --}}

                                <td class="px-6 py-4">

                                    @if ($category->user)
                                        <div class="text-sm font-medium text-slate-900">
                                            {{ $category->user->name }}
                                        </div>

                                        <div class="text-xs text-slate-500">
                                            {{ $category->user->email }}
                                        </div>
                                    @else
                                        <span
                                            class="inline-flex rounded-full bg-purple-100 px-2.5 py-1 text-xs font-medium text-purple-700">
                                            Global
                                        </span>
                                    @endif

                                </td>


                                {{-- Type --}}

                                <td class="px-6 py-4">

                                    @if ($category->type === 'income')
                                        <span
                                            class="inline-flex rounded-full bg-green-100 px-2.5 py-1 text-xs font-medium text-green-700">
                                            Income
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex rounded-full bg-red-100 px-2.5 py-1 text-xs font-medium text-red-700">
                                            Expense
                                        </span>
                                    @endif

                                </td>


                                {{-- Status --}}

                                <td class="px-6 py-4">

                                    @if ($category->is_active)
                                        <span
                                            class="inline-flex rounded-full bg-green-100 px-2.5 py-1 text-xs font-medium text-green-700">
                                            Active
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex rounded-full bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-600">
                                            Inactive
                                        </span>
                                    @endif

                                </td>


                                {{-- Created --}}

                                <td class="px-6 py-4 text-sm text-slate-500">

                                    {{ $category->created_at->format('M d, Y') }}

                                </td>


                                {{-- Actions --}}

                                <td class="px-6 py-4">

                                    <div class="flex justify-end gap-2">

                                        {{-- Edit --}}

                                        <a href="{{ route('admin.categories.edit', $category) }}"
                                            class="rounded-lg bg-indigo-50 px-3 py-2 text-xs font-medium text-indigo-700 hover:bg-indigo-100">
                                            Edit
                                        </a>


                                        {{-- Delete --}}

                                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this category?');">

                                            @csrf

                                            @method('DELETE')

                                            <button type="submit"
                                                class="rounded-lg bg-red-50 px-3 py-2 text-xs font-medium text-red-700 hover:bg-red-100">
                                                Delete
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6" class="px-6 py-12 text-center text-sm text-slate-500">
                                    No categories found.
                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>
@endsection
