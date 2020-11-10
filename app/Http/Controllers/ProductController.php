<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = DB::table('products')
                        ->orderBy('product_name','asc')
                        ->get();
        return view('product.index',['data_products' => $products]);
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
        $checker = DB::table('products')
                    ->where('product_name', $request->add_product_name)
                    ->where('model', $request->add_model)
                    ->count();
        
        $rules = array(
            'add_product_name' => 'required',
            'add_model'   => 'required'
        );

        $customMessages = array(
            'add_product_name.required' => 'The product name field is required.',
            'add_model.required'        => 'The product model field is required.'
        );

        $error = Validator::make($request->all(), $rules, $customMessages);

        if ($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        if ($checker == 1) {
            return response()->json(['match' => 'data']);
        }

        if ($request -> add_information == null){
            $add_information = '-';
        } else {
            $add_information = $request -> add_information;
        }
        
        DB::table('products')->insert([
            'product_name' => $request -> add_product_name,
            'model'        => $request -> add_model,
            'information'  => $add_information,
            'status'       => $request -> add_status,
            'created_at'   => \Carbon\Carbon::now(),
            'updated_at'   => \Carbon\Carbon::now()
        ]);

        return response()->json(['success' => 'data']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
         if ($request -> edit_information == null){
            $edit_information = '-';
        } else {
            $edit_information = $request -> edit_information;
        }

        DB::table('products')->where('id',$request->edit_id)->update([
            'information'  => $edit_information,
            'status'       => $request -> edit_status,
            'updated_at'   => \Carbon\Carbon::now()
        ]);

        return response()->json(['success' => 'data']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($product)
    {
        DB::table('products')->where('id',$product)->delete();
        return back();
    }
}
