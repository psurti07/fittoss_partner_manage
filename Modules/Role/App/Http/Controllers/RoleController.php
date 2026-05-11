<?php

namespace Modules\Role\App\Http\Controllers;

use App\DataTables\RoleDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(RoleDataTable $datatable)
    {
        return $datatable->render('role::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::all();

        return view('role::modals.addRole', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'permissions' => 'required|array',
                'permissions.*' => 'required|exists:permissions,id',
            ], [
                'permissions.required' => 'Please select at least one permission.',
            ]);

            $role = Role::create([
                'name' => $validatedData['name'],
            ]);

            if (isset($validatedData['permissions'])) {
                $permissions = Permission::whereIn('id', $validatedData['permissions'])->get();
                foreach ($permissions as $permission) {
                    $role->givePermissionTo($permission->name);
                }
            }

            return response()->json(['type' => 'success', 'message' => 'Role created successfully.'], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['type' => 'success', 'error' => 'Something went wrong.'], 500);
        }
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('role::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $allPermissions = Permission::all()->keyBy('id');
        $permissions = $role->permissions->pluck('id');

        return view('role::modals.editRole', compact('role', 'allPermissions', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'permissions' => 'nullable|array',
                'permissions.*' => 'exists:permissions,id',
            ]);

            $role = Role::findOrFail($id);
            $role->name = $validated['name'];
            $role->save();

            $permissionIds = $validated['permissions'] ?? [];
            if (! is_array($permissionIds)) {
                $permissionIds = json_decode($permissionIds, true);
            }

            // $permissionIds = array_map('intval', $permissionIds);
            $permissions = Permission::whereIn('id', $permissionIds)->pluck('name')->toArray();
            if (! empty($permissions)) {
                $role->syncPermissions($permissions);
            } else {
                $role->syncPermissions([]);
            }

            return response()->json(['type' => 'success', 'message' => 'Role updated successfully.'], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong.'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $role = Role::with('permissions')->findOrFail($id);
            $role->delete();
            return response()->json(['type' => 'success', 'message' => 'Role deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['type' => 'error', 'message' => 'Something went Wrong.']);
        }
    }
}
