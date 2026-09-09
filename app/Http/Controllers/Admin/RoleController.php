<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RoleController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Index
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $roles = Role::with([
            'permissions',
            'users',
        ])
            ->latest()
            ->get();

        return view(
            'admin.roles.index',
            compact('roles')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Create
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $permissions = Permission::orderBy('name')
            ->get();

        return view(
            'admin.roles.create',
            compact('permissions')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Store
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:roles,name',
            ],

            'description' => [
                'nullable',
                'string',
                'max:1000',
            ],

            'permissions' => [
                'nullable',
                'array',
            ],

            'permissions.*' => [
                'integer',
                'exists:permissions,id',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Create Role
        |--------------------------------------------------------------------------
        */

        $role = Role::create([
            'name' => Str::lower(
                trim($validated['name'])
            ),

            'description' => $validated['description'] ?? null,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Assign Permissions
        |--------------------------------------------------------------------------
        */

        $role->permissions()->sync(
            $validated['permissions'] ?? []
        );

        return redirect()
            ->route('admin.roles.index')
            ->with(
                'success',
                'Role created successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Show
    |--------------------------------------------------------------------------
    */

    public function show(Role $role)
    {
        /*
        | We don't have a separate role details page.
        | Send the admin to the edit page instead.
        */

        return redirect()
            ->route('admin.roles.edit', $role);
    }


    /*
    |--------------------------------------------------------------------------
    | Edit
    |--------------------------------------------------------------------------
    */

    public function edit(Role $role)
    {
        /*
        |--------------------------------------------------------------------------
        | Get All Permissions
        |--------------------------------------------------------------------------
        */

        $permissions = Permission::orderBy('name')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Load Current Role Permissions
        |--------------------------------------------------------------------------
        */

        $role->load('permissions');

        return view(
            'admin.roles.edit',
            compact(
                'role',
                'permissions'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Update
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        Role $role
    ) {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:roles,name,' . $role->id,
            ],

            'description' => [
                'nullable',
                'string',
                'max:1000',
            ],

            'permissions' => [
                'nullable',
                'array',
            ],

            'permissions.*' => [
                'integer',
                'exists:permissions,id',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Update Role
        |--------------------------------------------------------------------------
        */

        $role->update([
            'name' => Str::lower(
                trim($validated['name'])
            ),

            'description' => $validated['description'] ?? null,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Sync Permissions
        |--------------------------------------------------------------------------
        |
        | sync() removes old permissions and assigns
        | the permissions selected in the form.
        |
        */

        $role->permissions()->sync(
            $validated['permissions'] ?? []
        );

        return redirect()
            ->route('admin.roles.index')
            ->with(
                'success',
                'Role updated successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Destroy
    |--------------------------------------------------------------------------
    */

    public function destroy(Role $role)
    {
        /*
        |--------------------------------------------------------------------------
        | Don't Delete Role Assigned To Users
        |--------------------------------------------------------------------------
        */

        if ($role->users()->exists()) {
            return back()->with(
                'error',
                'This role cannot be deleted because users are assigned to it.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Remove Permission Relationships
        |--------------------------------------------------------------------------
        */

        $role->permissions()->detach();

        /*
        |--------------------------------------------------------------------------
        | Delete Role
        |--------------------------------------------------------------------------
        */

        $role->delete();

        return redirect()
            ->route('admin.roles.index')
            ->with(
                'success',
                'Role deleted successfully.'
            );
    }
}
