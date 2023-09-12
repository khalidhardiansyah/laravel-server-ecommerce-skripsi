<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Message\MessageResource;
use App\Models\Category;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $category = Category::all();
        return CategoryResource::collection($category);
    }
    public function store(StoreCategoryRequest $request, MessageResource $messageResource, Category $category)
    {
        $this->authorize('create', $category);
        Category::create($request->validated());
        return $messageResource->print("success","category berhasil dibuat",201);
    }

    public function show($id)
    {
        $category = Category::with("product.thumb")->findOrFail($id);
        return new CategoryResource($category);
    }

    public function update(StoreCategoryRequest $request, Category $category, MessageResource $messageResource)
    {
        $this->authorize('update', $category);
        $validate = $request->validated();
        $category->update($validate);
        return $messageResource->print("success","category berhasil diubah",201);

    }

    public function destroy(Category $category, MessageResource $messageResource)
    {
            $this->authorize('update', $category);
            $category->delete();
            return $messageResource->print("success","category berhasil dihapus",204);
    }
    }
