<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Web\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionsController extends Controller
{
    public function list()
    {
        if (!auth()->user()->hasPermissionTo('manage_roles')) {
            abort(403);
        }

        $permissions = Permission::all();
        return view('permissions.list', compact('permissions'));
    }

    public function edit(Permission $permission = null)
    {
        if (!auth()->user()->hasPermissionTo('manage_roles')) {
            abort(403);
        }
        
        return view('permissions.edit', compact('permission'));
    }

    public function save(Request $request, Permission $permission = null)
    {
        if (!auth()->user()->hasPermissionTo('manage_roles')) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'display_name' => ['required', 'string', 'max:255']
        ]);

        if (!$permission) {
            $permission = Permission::create([
                'name' => $validated['name'],
                'display_name' => $validated['display_name'],
                'guard_name' => 'web'
            ]);
        } else {
            $permission->update($validated);
        }

        return redirect()->route('permissions_list')->with('success', 'Permission saved successfully');
    }

    public function delete(Permission $permission)
    {
        if (!auth()->user()->hasPermissionTo('manage_roles')) {
            abort(403);
        }

        $permission->delete();
        return redirect()->route('permissions_list')->with('success', 'Permission deleted successfully');
    }
}