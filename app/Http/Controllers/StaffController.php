<?php

namespace App\Http\Controllers;

use App\Http\Requests\StaffStoreRequest;
use App\Http\Requests\StaffUpdateRequest;
use App\Http\Resources\StaffResource;
use App\Models\Staff;

class StaffController extends Controller
{
    public function index()
    {
        return StaffResource::collection(Staff::all());
    }

    public function store(StaffStoreRequest $request)
    {
        if (auth()->user()->role !== "admin") {
            return response()->json([
                "message" => "Only admins can do this"
            ], 403);
        }

        $staff = Staff::create($request->all());
        return StaffResource::make($staff);
    }

    public function show($id)
    {
        return StaffResource::make(Staff::findOrFail($id));
    }

    public function update(StaffUpdateRequest $request, $id)
    {
        if (auth()->user()->role !== "admin") {
            return response()->json([
                "message" => "Only admins can do this"
            ], 403);
        }

        $staff = Staff::findOrFail($id);
        $staff->update($request->all());
        return StaffResource::make($staff);
    }

    public function destroy($id)
    {
        if (auth()->user()->role !== "admin") {
            return response()->json([
                "message" => "Only admins can do this"
            ], 403);
        }

        Staff::findOrFail($id)->delete();
        return response()->json("Staff member deleted successfully.");
    }
}
