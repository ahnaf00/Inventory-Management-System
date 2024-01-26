<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    function ProductPage():View
    {
        return view('pages.dashboard.product-page');
    }

    function CreateProduct(Request $request)
    {
        $user_id = $request->header('id');
        // Prepare file name and path
        $img        = $request->file('img');
        $time       = time();
        $file_name  = $img->getClientOriginalName();
        $img_name   = "{$user_id}-{$time}-{$file_name}";
        $img_url    = "uploads/{$img_name}";

        // upload file
        $img->move(public_path('uploads'), $img_name);

        $product = Product::create([
            'name'          =>  $request->input('name'),
            'price'         =>  $request->input('price'),
            'unit'          =>  $request->input('unit'),
            'img_url'       =>  $img_url,
            'category_id'   =>  $request->input('category_id'),
            'user_id'       =>  $user_id
        ]);

        return $product;
    }

    function DeleteProduct(Request $request)
    {
        $user_id        = $request->header('id');
        $product_id     = $request->input('id');
        $filePath       = $request->input('file_path');
        File::delete($filePath);
        $product = Product::where('id', $product_id)->where('user_id', $user_id)->delete();
        return $product;
    }

    function ProductById(Request $request)
    {
        $user_id = $request->header('id');
        $product_id = $request->input('id');

        $product = Product::where('id', $product_id)->where('user_id', $user_id)->first();
        return $product;
    }

    function ProductList(Request $request)
    {
        $user_id = $request->header('id');
        $product = Product::where('user_id', $user_id)->get();

        return $product;
    }

    function UpdateProduct(Request $request)
    {
        $user_id = $request->header('id');
        $product_id = $request->input('id');

        if($request->hasFile('img'))
        {
            // upload new file
            $img        =   $request->file('img');
            $time       =   time();
            $file_name  =   $img->getClientOriginalName();
            $img_name   =   "{$user_id}-{$time}-{$file_name}";
            $img_url    =   "uploads/{$img_name}";
            $img->move(public_path('uploads'), $img_name);
            // delete existing file
            $filePath = $request->input('file_path');
            File::delete($filePath);

            // update product
            $product = Product::where('id', $product_id)->where('user_id', $user_id)->update([
                'name'          =>  $request->input('name'),
                'price'         =>  $request->input('price'),
                'unit'          =>  $request->input('unit'),
                'img_url'       =>  $img_url,
                'category_id'   =>  $request->input('category_id')
            ]);

            return $product;
        }
        else
        {
            $product = Product::where('id', $product_id)->where('user_id', $user_id)->update([
                'name'          =>  $request->input('name'),
                'price'         =>  $request->input('price'),
                'unit'          =>  $request->input('unit'),
                'category_id'   =>  $request->input('category_id')
            ]);
            return $product;

        }
    }
}
