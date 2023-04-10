<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        try {
            $categories = Category::with(['posts'])->get();

            return response()->json([
                'success' => true,
                'message' => 'Success when get Categories data',
                $categories
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error when get Categories data',
                'errors' => $e->getMessage()
            ], 500);
        }
    }

    public function show(CategoryRequest $request)
    {
        try {
            $category = Category::with(['posts'])->findOrFail($request->id);

            if (!$category) {
                return response()->json([
                    'success' => true,
                    'messages' => 'Success get Category data',
                    'data' => $category
                ], 200);
            }
            return response()->json($category);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error when get Category data',
                'errors' => $e->getMessage()
            ], 500);
        }
    }

    public function create(CategoryRequest $request)
    {
        try {
            $input = $request->all();
            $insert = Category::create($input);

            return response()->json([
                'success' => true,
                'message' => 'Category data has been added',
                'data' => $insert
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error when adding Category data',
                'errors' => $e->getMessage()
            ], 500);
        }
    }

    public function update(CategoryRequest $request)
    {
        try {
            $category = Category::findOrFail($request->id);

            $input = $request->all();
            $category->fill($input);
            $category->save();

            return response()->json([
                'success' => true,
                'message' => 'Category data has been updated',
                'data' => $category
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy(CategoryRequest $request)
    {
        try {
            $category = Category::findOrFail($request->id);
            $category->delete();

            return response()->json(['message' => 'Category deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}