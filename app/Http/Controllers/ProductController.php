<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\StorePostRequest;
use App\Models\Products;
use Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
        $products = Products::orderBy('id', 'asc')->paginate(10);

        return view('products.index', compact('products'));
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
            'image'   => 'required|image|mimes:jpg,png|max:100',
            'stock'     => 'required|numeric|min:0'
        ];

        $messages = [
            'name.required' => "Product Name is required",
            'name.unique' => "Product Name is already exists",
            'purchase.required' => "Purchase Price is required",
            'purchase.numeric' => "Purchase Price must be a number",
            'purchase.min' => "Purchase Price cannot be smaller than Zero",
            'selling.required' => "Selling Price is required",
            'selling.numeric' => "Selling Price must be a number",
            'selling.min' => "Selling Price cannot be smaller than Zero",
            'image.required' => "Picture is required",
            'image.image' => "Picture must be a format JPG or PNG",
            'image.max' => "Picture size cannot be bigger than 100kb",
            'stock.required' => "Stock is required",
            'stock.numeric' => "Stock must be a number",
            'stock.min' => "Stock cannot be smaller than Zero",

        ];

        $path = null;

        if (!empty($request->image)) {
            $path = Storage::putFileAs('public/products', $request->image, $request->name . ".jpg");
        }

        $data = [
            'image' => $path,
            'name'  => $request->name,
            'buy'   => $request->purchase,
            'sell'  => $request->selling,
            'stock' => $request->stock
        ];

        $validator = Validator::make($request->all(), $rule, $messages);

        if ($validator->fails()) {
            toast('Sorry, you cannot create data!', 'error');
            return redirect()->route('product.index')
                ->withErrors($validator)
                ->withInput();
        } else {
            Products::insert($data);
            toast('Create data product Successfully!', 'success');
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
        $product = Products::find($id);

        $return = '<div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Form Product</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="' . route('product.update', $product->id) . '" method="post" class="row g-3" enctype="multipart/form-data">
                            ' . csrf_field() . '
                            <input name="_method" type="hidden" value="PUT">
                            <div class="col-md-12">
                                <label for="name">Name Product</label>
                                <input type="text" name="name" id="name" class="form-control" value="' . $product->name . '">
                            </div>
                            <div class="col-md-6">
                                <label for="purchase" class="form-label">Purchase Price</label>
                                <input type="number" name="purchase" id="purchase" class="form-control" min="0" value="' . $product->buy . '">
                            </div>
                            <div class="col-md-6">
                                <label for="selling" class="form-label">Selling Price</label>
                                <input type="number" name="selling" id="selling" class="form-control" min="0" value="' . $product->sell . '">
                            </div>
                            <div class="col-md-12">
                                <label for="stock">Stock</label>
                                <input type="number" name="stock" id="stock" class="form-control" min="0" value="' . $product->stock . '">
                            </div>
                            <div class="col-md-12">
                                <label for="image" class="form-label">Image Product</label>
                                <input type="file" class="form-control" name="image" id="image" onclick="previewImage()">
                                <div class="col my-2 text-center">
                                    <img class="img-preview img-fluid " width="250px" height="250px" alt="old image" src="' . $product->getCover() . '">
                                </div>                               
                            </div>
                            <div class="col-md-12">                             
                                 <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                 <button type="submit" class="btn btn-warning">Save changes</button>
                            </div>
                            
                    </div>
                    </form>
                    
                    ';

        return $return;
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
        $rule = [
            'name'      => 'required',
            'purchase'  => 'required|numeric|min:0',
            'selling'   => 'required|numeric|min:0',
            'image'     => 'image|mimes:jpg,png|max:100',
            'stock'     => 'required|numeric|min:0'
        ];

        $product = Products::find($id);
        $name = $request->name;

        // Jika nama barang tidak sama
        if ($product->name != $name) {
            // maka cari nama barang di data nama barang
            $findName = Products::where('name', 'like', $name)->value('name');
            // jika data tidak ditemukan, beri nilai pada variable name
            // jika data di temukan, beri respon sistem
            if ($findName == Null) {
                $name = $request->name;
            } else {
                toast('Sorry, product name already exists!', 'error');
                return redirect()->route('product.index');
            }
        }

        $messages = [
            'name.required' => "Product Name is required",
            'purchase.required' => "Purchase Price is required",
            'purchase.numeric' => "Purchase Price must be a number",
            'purchase.min' => "Purchase Price cannot be smaller than Zero",
            'selling.required' => "Selling Price is required",
            'selling.numeric' => "Selling Price must be a number",
            'selling.min' => "Selling Price cannot be smaller than Zero",
            'image.image' => "Picture must be a format JPG or PNG",
            'image.max' => "Picture size cannot be bigger than 100kb",
            'stock.required' => "Stock is required",
            'stock.numeric' => "Stock must be a number",
            'stock.min' => "Stock cannot be smaller than Zero",
        ];

        $path = null;

        if (!empty($request->image)) {
            $path = Storage::putFileAs('public/products', $request->image, $name . ".jpg");
        }

        $data = [
            'image' => $path,
            'name'  => $name,
            'buy'   => $request->purchase,
            'sell'  => $request->selling,
            'stock' => $request->stock
        ];
        // dd($data);
        $validator = Validator::make($request->all(), $rule, $messages);

        if ($validator->fails()) {
            toast('Sorry, you cannot create data!', 'error');
            return redirect()->route('product.index')
                ->withErrors($validator)
                ->withInput();
        } else {
            Products::where('id', $id)->update($data);
            toast('Updated data product Successfully!', 'info');
            return redirect()->route('product.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Products::where('id', $id)->delete();
        toast('Deleted data product successfully', 'info');
        return redirect()->route('product.index');
    }
}
