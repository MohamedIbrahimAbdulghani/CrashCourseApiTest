<?php

namespace App\Http\Controllers;

use App\Http\Traits\ApiHandler;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use ApiHandler;   //  this trait is used to handle the API responses in a consistent manner


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        if($categories) {
            return $this->successMessage(trans('messages.categories_retrieved'), $categories, 200);
        } else {
            return $this->errorMessage(trans('messages.categories_not_found'), null, 404);
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
            return $this->successMessage(trans('messages.category_created'), $category, 201);
        } else {
            return $this->errorMessage(trans('messages.category_creation_failed'), null, 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::find($id);
        if($category) {
            return $this->successMessage(trans('messages.category_retrieved'), $category, 200);
        } else {
            return $this->errorMessage(trans('messages.category_not_found'), null, 404);
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
        $category = Category::find($id);
        if($category) {
            $category->update([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
        ]);
            return $this->successMessage(trans('messages.category_updated'), $category, 200);
        } else {
            return $this->errorMessage(trans('messages.category_not_found'), null, 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::find($id);
        if($category) {
            $category->delete();
            return $this->successMessage(trans('messages.category_deleted'), $category, 200);
        } else {
            return $this->errorMessage(trans('messages.category_not_found'), null, 404);
        }
    }
}
