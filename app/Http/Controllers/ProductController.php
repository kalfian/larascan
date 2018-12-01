<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use DB;
use Redirect;
use Validator;

class ProductController extends Controller
{
    public function getData(){
        $data = DB::table('products')->orderBy('id', 'desc')->get();
        return view('product.data',['datas' => $data]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        
        return view('product.index');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return redirect()->route('product.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $response = ['status' => '0'];
        // 
        $validator = Validator::make($request->all(), [
            'loc' => 'required',
            'batch' => 'required',
            'exp' => 'required',
            'karton' => 'required',
        ]);
        
        if ($validator->fails()) {
            $response['error_msg'] = $validator->errors();
            return response()->json($response);
        }
        
        $insert = DB::table('products')
        ->insert([
            'loc' => $request->loc,
            'batch' => $request->batch,
            'exp' => date('Y-m-d', strtotime(str_replace('/', '-', $request->exp))).' 00:00:00',
            'karton' => $request->karton,
            'status' => '2',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $response['status'] = '1';
        $response['msg'] = 'Success';
        $response['data'] = '<div class="alert alert-success alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        <strong>Success!</strong> Data successfully added</div>';
        return response()->json($response);

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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
