<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookStoreRequst;
use App\Http\Requests\BookUpdateRequst;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::query();

        if ($request->search) {
            $query->where("name", "like", "%" . $request->search . "%");
        }
        if ($request->category_id) {
            $query->where("category_id", $request->category_id);
        }

        return BookResource::collection($query->get());
    }

    public function store(BookStoreRequst $request)
    {
        $book = Book::create($request->validated());
        return BookResource::make($book);
    }

    public function show(Book $book)
    {
        return new BookResource($book->load("category"));
    }

    public function update(BookUpdateRequst $request, Book $book)
    {
        $book->update($request->validated());
        return BookResource::make($book);
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return response()->json([
            "message" => "deleted"
        ]);
    }
}
