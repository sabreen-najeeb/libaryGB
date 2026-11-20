<?php

namespace App\Http\Controllers;

use App\Models\Customer;
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

    public function markAsReturned(Request $request){
        $request->validate([
            'customer_id' => ['required', 'exists:customers,id'],
            'book_id'     => ['required', 'exists:books,id'],
        ]);

        $customer = Customer::find($request->customer_id);

        $borrowing = $customer->books()
            ->wherePivot('book_id', $request->book_id)
            ->wherePivot('is_returned', false)
            ->first();

        if (!$borrowing) {
            return response()->json([
                'message' => 'This customer has no open borrowing for this book'
            ], 404);
        }

        $customer->books()
            ->wherePivot('is_returned', false)
            ->updateExistingPivot($request->book_id, [
                'is_returned' => true,
            ]);

        return response()->json([
            'message'        => 'Book marked as returned',
            'customer_id'    => $customer->id,
            'book_id'        => $borrowing->id,
            'borrowing_date' => $borrowing->pivot->borrowing_date,
        ]);
    }
}
