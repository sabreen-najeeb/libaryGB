<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return CategoryResource::collection($categories);
    }

    public function store(CategoryStoreRequest $request)
    {
        $category = Category::create($request->validated());
        return CategoryResource::make($category);
    }

    public function show(Category $category)
    {
        return new CategoryResource($category->load("books"));
    }

    public function update(CategoryUpdateRequest $request, Category $category)
    {
        $category->update($request->validated());
        return CategoryResource::make($category);
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json([
            "message" => "deleted"
        ]);
    }
}
