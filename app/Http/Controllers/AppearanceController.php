<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAppearanceRequest;
use App\Http\Requests\UpdateAppearanceRequest;
use App\Models\Appearance;
use Illuminate\Http\Request;

class AppearanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            "error" => 'nullable',
            "info" => 'nullable',
            "primary" => 'nullable',
            "secondary" => 'nullable',
            "success" => 'nullable',
            "warning" => 'nullable',
        ]);

        // Use the first or create method to simplify the logic
        Appearance::updateOrCreate([], $validatedData);
    }

    /**
     * Display the specified resource.
     */
    public function show(Appearance $appearance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Appearance $appearance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAppearanceRequest $request, Appearance $appearance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appearance $appearance)
    {
        //
    }



    public function getThemeColors()
    {
        $theme = Appearance::first(); // Or any logic to get the active theme

        return response()->json([
            'colors' => [
                'primary' => $theme->primary,
                'secondary' => $theme->secondary,
                'info' => $theme->info,
                'success' => $theme->success,
                'warning' => $theme->warning,
                'error' => $theme->error,
            ]
        ]);
    }
}
