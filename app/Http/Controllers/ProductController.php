<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use App\Http\Requests\ProductCreateRequest;
use App\Http\Requests\ProductUpdateRequest;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();

        return response()->json([
            'data' => $products
        ]);
    }

    public function store(ProductCreateRequest $request)
    {
        $data = $request->validated();

        if (!empty($request->photo)) {
            $strpos = strpos($request->photo, ';');
            $sub = substr($request->photo, 0, $strpos);
            $ex = explode('/', $sub)[1];
            $name = time() . '.' . $ex;
            $img = Image::make($request->photo)->resize(200, 200);
            $upload_path = public_path() . '/upload/';
            $img->save($upload_path . $name);
            $data['photo'] = $name;
        } else {
            $data['photo'] = 'image.png';
        }

        return Product::create($data);
    }

    public function show($id)
    {
        $product = Product::find($id);
        return response()->json([
            'data' => $product
        ]);
    }

    public function update($id, ProductUpdateRequest $request)
    {
        $product = Product::find($id);
        $data = $request->validated();
        if (!empty($request->photo)) {
            $strpos = strpos($request->photo, ';');
            $sub = substr($request->photo, 0, $strpos);
            $ex = explode('/', $sub)[1];
            $name = time() . '.' . $ex;
            $img = Image::make($request->photo)->resize(200, 200);
            $upload_path = public_path() . '/upload/';
            $img->save($upload_path . $name);
            $oldImg = $upload_path . $product->photo;
            if (file_exists($oldImg)) {
                @unlink($oldImg);
            }

            $data['photo'] = $name;
        } else {
            $data['photo'] = $product->photo;
        }
        return $product->update($data);
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        $upload_path = public_path() . '/upload/';
        $oldImg = $upload_path . $product->photo;
        if (file_exists($oldImg)) {
            @unlink($oldImg);
        }
        return $product->delete();
    }
}