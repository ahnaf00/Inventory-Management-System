<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
class CategoryController extends Controller
{
    function CategoryPage()
    {
        return view('pages.dashboard.category-page');
    }

    function CategoryList(Request $request)
    {
        $user_id    = $request->header('id');
        $category   =  Category::where('user_id', $user_id)->get();
        return $category;
    }

    function CategoryCreate(Request $request)
    {
        $user_id    = $request->header('id');
        $category   = Category::create([
            'name'      =>  $request->input('name'),
            'user_id'   =>  $user_id
        ]);
        return $category;
    }

    function CategoryDelete(Request $request)
    {
        $category_id    = $request->input('id');
        $user_id        = $request->header('id');

        $category = Category::where('id', $category_id)->where('user_id', $user_id)->delete();
        return $category;
    }

    function CategoryById(Request $request)
    {
        $category_id    = $request->input('id');
        $user_id        = $request->header('id');

        $category = Category::where('id', $category_id)->where('user_id', $user_id)->first();
        return $category;
    }

    function CategoryUpdate(Request $request)
    {
        $category_id    = $request->input('id');
        $user_id        = $request->header('id');

        $category = Category::where('id', $category_id)->where('user_id', $user_id)->update([
            'name'=>$request->input('name')
        ]);
        return $category;
    }
}
