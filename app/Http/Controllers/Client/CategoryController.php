<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function getCategories()
    {
        $categoies = Category::select('id', 'name')->where('status', 1)->get();
        return response()->json([
            'status' => true,
            'categories' => $categoies
        ]);
    }
}
