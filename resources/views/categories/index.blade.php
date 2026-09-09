@extends('layouts.app')

@section('content')

    <div class="mx-auto max-w-7xl space-y-8 py-6">

        {{-- Header --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <p class="text-sm font-medium text-slate-500">
                    Finance Management
                </p>

                <h1 class="mt-1 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                    Categories
                </h1>

                <p class="mt-1 text-sm text-slate-500 sm:text-base">
                    Organize your income and expenses into categories.
                </p>
            </div>

            <a href="{{ url('/categories/create') }}"
                class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-slate-800">
                + Add Category
            </a>

        </div>


        {{-- Summary --}}
        <div class="grid gap-4 sm:grid-cols-3">

            {{-- Total --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-slate-500">
                    Total Categories
                </p>

                <p class="mt-2 text-2xl font-bold text-slate-900">
                    {{ $categories->count() }}
                </p>
            </div>


            {{-- Income --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-slate-500">
                    Income Categories
                </p>

                <p class="mt-2 text-2xl font-bold text-emerald-600">
                    {{ $categories->where('type', 'income')->count() }}
                </p>
            </div>


            {{-- Expense --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-slate-500">
                    Expense Categories
                </p>

                <p class="mt-2 text-2xl font-bold text-red-600">
                    {{ $categories->where('type', 'expense')->count() }}
                </p>
            </div>

        </div>


        {{-- Success Message --}}
        @if (session('success'))
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
                {{ session('success') }}
            </div>
        @endif


        {{-- Categories --}}
        @if ($categories->count())
            <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">

                @foreach ($categories as $category)
                    <div
                        class="group rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">

                        {{-- Top --}}
                        <div class="flex items-start justify-between gap-4">

                            <div class="flex items-center gap-3">

                                <div
                                    class="flex h-11 w-11 items-center justify-center rounded-xl
                                {{ $category->type === 'income' ? 'bg-emerald-50 text-emerald-600' : 'bg-red-50 text-red-600' }}">

                                    @if ($category->type === 'income')
                                        ↑
                                    @else
                                        ↓
                                    @endif

                                </div>

                                <div>
                                    <h3 class="font-semibold text-slate-900">
                                        {{ $category->name }}
                                    </h3>

                                    <p class="mt-0.5 text-xs capitalize text-slate-500">
                                        {{ $category->type }}
                                    </p>
                                </div>

                            </div>


                            {{-- Status --}}
                            @if ($category->is_active)
                                <span class="rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700">
                                    Active
                                </span>
                            @else
                                <span class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-500">
                                    Inactive
                                </span>
                            @endif

                        </div>


                        {{-- Description --}}
                        <div class="mt-5 border-t border-slate-100 pt-4">

                            <p class="text-sm text-slate-500">
                                Used for
                                <span class="font-medium capitalize text-slate-700">
                                    {{ $category->type }}
                                </span>
                                transactions.
                            </p>

                        </div>


                        {{-- Actions --}}
                        <div class="mt-5 flex gap-2">

                            <a href="{{ url('/categories/' . $category->id . '/edit') }}"
                                class="flex-1 rounded-xl border border-slate-300 px-3 py-2 text-center text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                                Edit
                            </a>

                            <form action="{{ url('/categories/' . $category->id) }}" method="POST" class="flex-1">
                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                    onclick="return confirm('Are you sure you want to delete this category?')"
                                    class="w-full rounded-xl border border-red-200 px-3 py-2 text-sm font-semibold text-red-600 transition hover:bg-red-50">
                                    Delete
                                </button>

                            </form>

                        </div>

                    </div>
                @endforeach

            </div>
        @else
            {{-- Empty State --}}
            <div class="rounded-2xl border border-dashed border-slate-300 bg-white px-6 py-16 text-center">

                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-slate-100 text-2xl">
                    ≡
                </div>

                <h3 class="mt-5 text-lg font-semibold text-slate-900">
                    No categories yet
                </h3>

                <p class="mx-auto mt-2 max-w-md text-sm text-slate-500">
                    Create categories such as Salary, Food, Transport, Rent,
                    Shopping, and more to organize your transactions.
                </p>

                <a href="{{ url('/categories/create') }}"
                    class="mt-6 inline-flex rounded-xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white hover:bg-slate-800">
                    Create Your First Category
                </a>

            </div>
        @endif

    </div>

@endsection
