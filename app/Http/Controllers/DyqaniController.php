<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Products;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DyqaniController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $totali = 0;
        $categories = Categories::all();
        $product = DB::table('dyqani')
            ->join('products', 'dyqani.product_id', '=', 'products.id')
            ->select('products.emertimi as name','products.cmim_shitje as cmimi', 'dyqani.*')->get();
        foreach ($product as $item) {
            $totali = $totali + $item->total;
        }
        return view('pages.dyqani')->with([
            'categories' => $categories,
            'products' => $product,
            'totali' => $totali
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createInvoice()
    {
        $date = date('d-m-Y');
        $total = 0;
        $products = DB::table('dyqani')
            ->join('products', 'dyqani.product_id', '=', 'products.id')
            ->select('products.emertimi as name','products.cmim_shitje as cmimi', 'dyqani.*')->get();
        foreach ($products as $product){
            $total = $total + $product->total;
        }
        $uniqueId = uniqid();
        $flieName = $date.'-dyqani-'.$uniqueId.'-fatura.pdf';
        $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true]);
        $pdf->loadView('invoices.storeInvoice', ['data' => $products, 'date' => $date, 'total'=>$total]);
        $pdf->save(public_path().'/invoices/store/'.$flieName);
        $insertArray = [
            'data' => $date,
            'total' => $total,
            'invoice' => $flieName
        ];
        $insert = DB::table('dyqani_invoices')->insert($insertArray);
        if ($insert){
            foreach ($products as $product) {
                DB::table('sasia')->where('product_id', '=', $product->product_id)->decrement('sasia', $product->sasia);
                DB::table('dyqani')->where('id', '=', $product->id)->delete();
            }
        }
        return $pdf->stream(public_path().'/invoices/store/'.$flieName);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'product_id' => 'required|numeric',
            'sasia' => 'required|numeric'
        ];

        $messages = [
            'required'  => ':attribute nuk mund te lihet bosh',
            'numeric'    => ':attribute nuk eshte numer',
        ];

        $validatedData = $request->validate($rules, $messages);
        $produkt = Products::where('id', $request->product_id)->first();
        $sasia = DB::table('sasia')->where('product_id', '=', $request->product_id)->first();
        if ($sasia->sasia < $request->sasia){
            return redirect()->back()->withErrors(['Kujdes, nuk ka gjendje ne magazine']);
        }
        $total = $produkt->cmim_shitje * $request->sasia;
        $insert = [
            'product_id'=> $request->product_id,
            'sasia' => $request->sasia,
            'total' => $total
        ];
        $db = DB::table('dyqani')->insert($insert);
        if ($db){
            return redirect()->back()->with('data', ['msg' => 'Produkti u Shtua me Sukses ne Fature']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function history()
    {
        $history = DB::table('dyqani_invoices')->get();
        return view('pages.history')->with('histories', $history);
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
        DB::table('dyqani')->where('id', '=', $id)->delete();
        return redirect()->back()->with('data', ['msg' => 'Produkti u Hoq']);
    }
}
