<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Staff;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Staff::all());

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:staff,email',
            'password' => 'required|string|min:8',
            'role' => 'required|string',
            'phone_number' => 'required|string|unique:staff,phone_number',
        ]);

        $staff = Staff::create($validated);

        return response()->json($staff, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json(Staff::findOrFail($id));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $staff = Staff::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|required|string',
            'email' => 'sometimes|required|email|unique:staff,email,' . $staff->id,
            'password' => 'sometimes|required|string|min:8',
            'role' => 'sometimes|required|string',
            'phone_number' => 'sometimes|required|string|unique:staff,phone_number,' . $staff->id,
        ]);

        $staff->update($validated);

        return response()->json($staff);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Staff::findOrFail($id)->delete();

        return response()->json("Staff member deleted successfully.");
    }
}
