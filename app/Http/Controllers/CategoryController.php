<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | USER - INDEX
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        /** @var User $user */
        $user = Auth::user();

        $categories = $user
            ->categories()
            ->latest()
            ->get();

        return view(
            'categories.index',
            compact('categories')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | USER - CREATE
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        return view('categories.create');
    }


    /*
    |--------------------------------------------------------------------------
    | USER - STORE
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'type' => [
                'required',
                'in:income,expense',
            ],

            'is_active' => [
                'nullable',
                'boolean',
            ],
        ]);

        $validated['user_id'] = Auth::id();

        $validated['is_active'] = $request->boolean('is_active');

        /*
        |--------------------------------------------------------------------------
        | Check Duplicate Category
        |--------------------------------------------------------------------------
        */

        $exists = Category::where('user_id', Auth::id())
            ->where('name', $validated['name'])
            ->where('type', $validated['type'])
            ->exists();

        if ($exists) {
            return back()
                ->withErrors([
                    'name' => 'You already have this category.',
                ])
                ->withInput();
        }

        Category::create($validated);

        return redirect()
            ->route('categories.index')
            ->with(
                'success',
                'Category created successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | USER - SHOW
    |--------------------------------------------------------------------------
    */

    public function show(Category $category)
    {
        $this->authorizeCategory($category);

        return redirect()
            ->route('categories.index');
    }


    /*
    |--------------------------------------------------------------------------
    | USER - EDIT
    |--------------------------------------------------------------------------
    */

    public function edit(Category $category)
    {
        $this->authorizeCategory($category);

        return view(
            'categories.edit',
            compact('category')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | USER - UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        Category $category
    ) {
        $this->authorizeCategory($category);

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'type' => [
                'required',
                'in:income,expense',
            ],

            'is_active' => [
                'nullable',
                'boolean',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Check Duplicate Category
        |--------------------------------------------------------------------------
        */

        $exists = Category::where('user_id', Auth::id())
            ->where('name', $validated['name'])
            ->where('type', $validated['type'])
            ->where('id', '!=', $category->id)
            ->exists();

        if ($exists) {
            return back()
                ->withErrors([
                    'name' => 'You already have this category.',
                ])
                ->withInput();
        }

        $validated['is_active'] = $request->boolean('is_active');

        $category->update($validated);

        return redirect()
            ->route('categories.index')
            ->with(
                'success',
                'Category updated successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | USER - DESTROY
    |--------------------------------------------------------------------------
    */

    public function destroy(Category $category)
    {
        $this->authorizeCategory($category);

        /*
        |--------------------------------------------------------------------------
        | Prevent deletion if category has transactions
        |--------------------------------------------------------------------------
        */

        if ($category->transactions()->exists()) {
            return back()->with(
                'error',
                'This category cannot be deleted because it has transactions.'
            );
        }

        $category->delete();

        return redirect()
            ->route('categories.index')
            ->with(
                'success',
                'Category deleted successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | USER - OWNERSHIP CHECK
    |--------------------------------------------------------------------------
    */

    private function authorizeCategory(Category $category)
    {
        if ($category->user_id !== Auth::id()) {
            abort(403);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | ADMIN - INDEX
    |--------------------------------------------------------------------------
    */

    public function adminIndex()
    {
        $categories = Category::with('user')
            ->latest()
            ->get();

        return view(
            'admin.categories.index',
            compact('categories')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ADMIN - CREATE
    |--------------------------------------------------------------------------
    */

    public function adminCreate()
    {
        $users = User::orderBy('name')->get();

        return view(
            'categories.create',
            compact('users')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ADMIN - STORE
    |--------------------------------------------------------------------------
    */

    public function adminStore(Request $request)
    {
        $validated = $request->validate([
            'user_id' => [
                'nullable',
                'exists:users,id',
            ],

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'type' => [
                'required',
                'in:income,expense',
            ],

            'is_active' => [
                'nullable',
                'boolean',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Check Duplicate Category
        |--------------------------------------------------------------------------
        */

        $exists = Category::where(
            'user_id',
            $validated['user_id'] ?? null
        )
            ->where('name', $validated['name'])
            ->where('type', $validated['type'])
            ->exists();

        if ($exists) {
            return back()
                ->withErrors([
                    'name' => 'This category already exists for this user.',
                ])
                ->withInput();
        }

        $validated['is_active'] = $request->boolean('is_active');

        Category::create($validated);

        return redirect()
            ->route('admin.categories.index')
            ->with(
                'success',
                'Category created successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | ADMIN - EDIT
    |--------------------------------------------------------------------------
    */

    public function adminEdit(Category $category)
    {
        $users = User::orderBy('name')->get();

        return view(
            'categories.edit',
            compact('category', 'users')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ADMIN - UPDATE
    |--------------------------------------------------------------------------
    */

    public function adminUpdate(
        Request $request,
        Category $category
    ) {
        $validated = $request->validate([
            'user_id' => [
                'nullable',
                'exists:users,id',
            ],

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'type' => [
                'required',
                'in:income,expense',
            ],

            'is_active' => [
                'nullable',
                'boolean',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Check Duplicate Category
        |--------------------------------------------------------------------------
        */

        $exists = Category::where(
            'user_id',
            $validated['user_id'] ?? null
        )
            ->where('name', $validated['name'])
            ->where('type', $validated['type'])
            ->where('id', '!=', $category->id)
            ->exists();

        if ($exists) {
            return back()
                ->withErrors([
                    'name' => 'This category already exists for this user.',
                ])
                ->withInput();
        }

        $validated['is_active'] = $request->boolean('is_active');

        $category->update($validated);

        return redirect()
            ->route('admin.categories.index')
            ->with(
                'success',
                'Category updated successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | ADMIN - DESTROY
    |--------------------------------------------------------------------------
    */

    public function adminDestroy(Category $category)
    {
        /*
        |--------------------------------------------------------------------------
        | Prevent deletion if category has transactions
        |--------------------------------------------------------------------------
        */

        if ($category->transactions()->exists()) {
            return back()->with(
                'error',
                'This category cannot be deleted because it has transactions.'
            );
        }

        $category->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with(
                'success',
                'Category deleted successfully.'
            );
    }
}
