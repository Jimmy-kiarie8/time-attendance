<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\BaseController;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends  BaseController
{
    public function __construct()
    {
        // Set properties specific to IngredientController
        $this->modelClass = User::class;
        $this->model = new User();
        $this->json = 'users.json';
        $this->title = 'Users';
        $this->route = 'users';
        $this->upload = false;


        $this->actions = [
            ['action_name' => 'Edit', 'icon' => 'mdi-pencil', 'color' => 'primary', 'route' => 'loans'],
            ['action_name' => 'Delete', 'icon' => 'mdi-delete', 'color' => 'error', 'route' => 'loans'],
            // Add more actions as needed
        ];
    }
    public function officers() {
        return User::role('Loan Officer')->paginate(100);
    }

    public function profile(Request $request, $id)
    {
        // Validate the image file
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Handle file upload
        if ($request->hasFile('file')) {
            $image = $request->file('file');
            $imageName = time() . '.' . $image->getClientOriginalExtension(); // Generate a unique file name

            // Save the file in the 'storage/app/logo' directory
            $image->move(public_path('storage/profile'), $imageName);

            // Return a success response with the storage path

            $company = User::find($id);
            $company->profile_photo_path = '/profile/' . $imageName;
            $company->save();
            return response()->json(['message' => 'Profile Updated', 'data' => $company]);
        }


        return response()->json(['error' => 'No image uploaded'], 400);
    }
}
