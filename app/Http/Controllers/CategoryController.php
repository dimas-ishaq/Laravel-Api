<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    //

    public function create(Request $request){
        $validated = $request->validate([
            'name'=>'required'
        ]);

        $category = Category::create($validated);
        return response()->json([
            'status'=>true,
            'message'=>'Category created successfully',
            'data'=>$category
        ]);
    }
}
