<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\BaseController;
use App\Models\Permission;
use App\Models\Role;

class PermissionController extends BaseController
{
    public function __construct()
    {
        $this->modelClass = Permission::class;
        $this->model = new Permission();
        $this->json = 'permissions.json';
        $this->title = 'Permission';
        $this->route = 'permissions';
        $this->upload = false;
        // $this->modalWidth = 1200;


        $this->actions = [
            ['action_name' => 'Edit', 'icon' => 'mdi-pencil', 'color' => 'primary', 'route' => 'permissions'],
            ['action_name' => 'Delete', 'icon' => 'mdi-delete', 'color' => 'error', 'route' => 'permissions'],
            // Add more actions as needed
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Fetch all permissions
        $permissions = Permission::all();

        // Fetch the role
        if ($id != 0) {
            $role = Role::find($id);
        }

        // Initialize an empty array to store grouped permissions
        $groupedPermissions = [];

        // Group permissions by a common prefix in their names
        foreach ($permissions as $permission) {
            // Extract the prefix from the permission name (e.g., "View", "Edit")
            $prefix = explode(' ', $permission->name)[1];

            // Check if the role has this permission
            if ($id != 0) {
                $hasPermission = $role->permissions->contains($permission);
            } else {
                $hasPermission = false;
            }
            // Add the permission to the corresponding group with the boolean flag
            $groupedPermissions[$prefix][] = [
                'id' => $permission->id,
                'name' => $permission->name,
                'has_permission' => $hasPermission,
            ];
        }

        // Return the grouped permissions as JSON response
        return response()->json($groupedPermissions);
    }
}
