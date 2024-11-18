<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmailConfigRequest;
use App\Http\Requests\UpdateEmailConfigRequest;
use App\Models\EmailConfig;

class EmailConfigController extends Controller
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
    public function store(StoreEmailConfigRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(EmailConfig $emailConfig)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EmailConfig $emailConfig)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmailConfigRequest $request, EmailConfig $emailConfig)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EmailConfig $emailConfig)
    {
        //
    }
}
