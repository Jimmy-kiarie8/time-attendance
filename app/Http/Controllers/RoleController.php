<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\BaseController;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Services\DataTransformService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class RoleController extends BaseController
{

    public function __construct()
    {
        // Set properties specific to IngredientController
        $this->modelClass = Role::class;
        $this->model = new Role();
        $this->json = 'roles.json';
        $this->title = 'Role';
        $this->route = 'roles';
        $this->upload = false;

        $this->modalWidth = 1200;

        $this->actions = [
            ['action_name' => 'Edit', 'icon' => 'mdi-pencil', 'color' => 'primary', 'route' => 'roles'],
            ['action_name' => 'Delete', 'icon' => 'mdi-delete', 'color' => 'error', 'route' => 'roles'],
            // Add more actions as needed
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        if (request('axios')) {
            return $this->model->paginate(100);
        }
        $roles = Role::paginate(100);

        $jsonFile = public_path('data/roles.json'); // Get the full path to the JSON file

        $permissions = Permission::all();
        $trans = new DataTransformService;
        $jsonData = $trans->data_transform($jsonFile);


        $headers = [];
        $headers[] = ['title' => 'Created At', 'key' => 'created_at'];

        foreach ($jsonData as $item) {
            if ($item['table_display']) {
                $headers[] = [
                    'title' => $item['label'],
                    'key' => $item['model']
                ];
            }
        }

        $headers[] = ['title' => 'Actions', 'key' => 'actions'];

        return Inertia::render('Roles/index', [
            'data' => $roles,
            'permissions' => $permissions,
            'headers' => $headers,
            'actions' => $this->actions,
            'title' => 'Roles',
            'modelRoute' => 'roles',
            'upload' => false
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $role = Role::create(['name' => $request->name, 'guard_name' => 'web']);
            $role->givePermissionTo(Permission::whereIn('id', $request->permissions)->get());
            DB::commit();
            return redirect()->back()->with('message', 'Role created');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
    /**
     * Store a newly created resource in storage.
     */

    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $role = Role::findOrFail($id);

            // Retrieve permissions based on the IDs received in the request
            $permissions = Permission::whereIn('id', $request->permissions)->get();

            // Sync the permissions for the role
            $role->syncPermissions($permissions);

            DB::commit();
            return redirect()->back()->with('message', 'Role permissions updated successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
