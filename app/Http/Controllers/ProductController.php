<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use DB;
use Redirect;
use Validator;
use DNS1D;
use DNS2D;
use PDF;

class ProductController extends Controller
{
    public function getData(){
        $data = DB::table('products')->orderBy('id', 'desc')->get();
        foreach ($data as $datas){
            $datas->barcode = date('ymdHis', strtotime(str_replace('/', '-', $datas->created_at))).str_pad($datas->id, 3, "0", STR_PAD_LEFT);
        }
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
            'exp' => $request->exp,
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
    public function show(Product $product,$ukuran = "A4")
    {
        $available = ['A4','A5','B5'];
        if(in_array($ukuran,$available)){
            $ukur = $ukuran;
        }else{
            $ukur = "A4";
        }
        
        $barcode = date('ymdHis', strtotime(str_replace('/', '-', $product->created_at))).str_pad($product->id, 3, "0", STR_PAD_LEFT);;
        $product->barcode = $barcode;
        // print_r($barcode);
        // print_r($ukuran);
        $pdf = PDF::loadView('product.detail',$product,[],[
            'format' => $ukur,
        ]);
        return $pdf->stream('Report_'.$product->loc.'_'.date('Y-m-d H:i:s'));

        // return view('product.detail',['barcode' => $barcode,'karton' => $product->karton]);
    }
    public function allDownload(Request $request,$ukuran = "A4")
    {
        
        $available = ['A4','A5','B5'];
        if(in_array($ukuran,$available)){
            $ukur = $ukuran;
        }else{
            $ukur = "A4";
        }
        if($request->d){
            $d = $request->d;
            $dataId = explode(",",$d);
            $data = DB::table('products')
                    ->select('created_at','karton','id','loc')
                    ->whereIn('id',$dataId)
                    ->get();
        }else{
            $data = DB::table('products')->select('created_at','karton','id','loc')->get();
        }
        foreach ($data as $datas){
            $datas->barcode = date('ymdHis', strtotime(str_replace('/', '-', $datas->created_at))).str_pad($datas->id, 3, "0", STR_PAD_LEFT);
        }
        // $barcode = 
        // $product->barcode = $barcode;
        // print_r($barcode);
        // print_r($data);
        $pdf = PDF::loadView('product.alldetail',compact('data'),[],[
            'format' => $ukur,
        ]);
        return $pdf->stream();
        // return view('product.alldetail',compact('data'));
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
