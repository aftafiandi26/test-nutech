<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\StorePostRequest;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('products.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rule = [
            'name'      => 'required|unique:product',
            'purchase'  => 'required|numeric|min:0',
            'selling'   => 'required|numeric|min:0',
            'picture'   => 'required|image|mimes:jpg,png|max:100',
            'stock'     => 'required|numeric|min:0'
        ];

        $messages = [
            'name.required' => 'Product Name is required',
            'name.unique' => 'Product Name is already exists',
            'purchase.required' => 'Purchase Price is required',
            'purchase.numeric' => 'Purchase Price must be a number',
            'purchase.min' => 'Purchase Price cannot be smaller than Zero',
            'selling.required' => 'Selling Price is required',
            'selling.numeric' => 'Selling Price must be a number',
            'selling.min' => 'Selling Price cannot be smaller than Zero',
            'picture.required' => 'Picture is required',
            'picture.image' => 'Picture must be a format JPG or PNG',
            'picture.max' => 'Picture size cannot be bigger than 100kb',
            'stock.required' => 'Stock is required',
            'stock.numeric' => 'Stock must be a number',
            'stock.min' => 'Stock cannot be smaller than Zero',

        ];

        $validator = Validator::make($request->all(), $rule, $messages);

        if ($validator->fails()) {
            return redirect()->route('product.index')
                ->withErrors($validator)
                ->withInput();
        } else {
            $post = new Products();
            $post->image = $request->picture;
            $post->name = $request->name;
            $post->buy = $request->purchase;
            $post->sell = $request->selling;
            $post->stoc = $request->stock;
            $post->save();

            return redirect()->route('product.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
