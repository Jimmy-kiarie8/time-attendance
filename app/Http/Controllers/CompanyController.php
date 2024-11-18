<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Company::first();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        return Company::updateOrCreate([
            'id' => $request->id,
        ], $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        return Company::find($id)->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        //
    }
    public function logo(Request $request, $id)
    {
        // Validate the image file
        // $request->validate([
        //     'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        // ]);

        // Handle file upload
        if ($request->hasFile('file')) {
            $image = $request->file('file');
            $imageName = time() . '.' . $image->getClientOriginalExtension(); // Generate a unique file name

            // Save the file in the 'storage/app/logo' directory
            $image->move(public_path('storage/logo'), $imageName);

            // Return a success response with the storage path

            $company = Company::find($id);
            $company->logo = '/storage/logo/' . $imageName;
            $company->save();
            return response()->json(['message' => 'Logo Updated', 'data' => $company]);
        }


        return response()->json(['error' => 'No image uploaded'], 400);
    }
}
