<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class borrowingsController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        return response()->json(["data" => $user->books]);
    }

    public function borrow(Request $request){
        $data = $request->validate([
            "book_id"        => ["required", "exists:books,id"],
            "borrowing_date" => ["required", "date"],
            "return_date"    => ["required", "date"]
        ]);

        $output = auth()->user()->books()->attach(
            ["book_id" => $data["book_id"]],
            ["borrowing_date" => $data["borrowing_date"],
             "return_date"    => $data["return_date"],
             "is_returned"    => false]
        );
        return response()->json(['data' => $output]);
    }

    public function destroy($id){
        $user = auth()->user();
        $user->books()->detach($id);
        return response()->json(['message' => 'done']);
    }
}
