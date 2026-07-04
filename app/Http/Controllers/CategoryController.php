<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        if($categories) {
            return response()->json([
            'status' => true,
            'message' => trans('messages.categories_retrieved'),
            'data' => $categories
        ], 200);
        } else {
            return response()->json([
            'status' => false,
            'message' => 'No categories found',
        ], 404);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $category = Category::create([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
        ]);
        if($category){
            return response()->json([
                'status' => true,
                'message' => 'Category created successfully',
                'data' => $category
            ], 201);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Category creation failed',
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::findOrFail($id);
        if($category) {
            return response()->json([
                'status' => true,
                'message' => 'Category retrieved successfully',
                'data' => $category
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Category not found',
            ], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = Category::findOrFail($id);
        if($category) {
            $category->update([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
        ]);
            return response()->json([
                'status' => true,
                'message' => 'Category updated successfully',
                'data' => $category
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Category not found',
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        if($category) {
            $category->delete();
            return response()->json([
                'status' => true,
                'message' => 'Category deleted successfully',
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Category not found',
            ], 404);
        }
    }
}
