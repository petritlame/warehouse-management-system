<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = DB::table('products')
            ->join('sasia', 'products.id', '=', 'sasia.product_id')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->select('products.*','products.emertimi as emri', 'sasia.sasia', 'categories.emertimi')
            ->where('categories.emertimi', '=', 'detergjente')
            ->get();
        $catecories = DB::table('categories')->get();
        return view('pages.index')->with(['category' => 'Detergjent', 'products' => $products, 'categories' => $catecories]);
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
        $validatedData = $request->validate([
            'emertimi'    => 'required|unique:products',
            'cmim_blerje' => 'required|numeric',
            'cmim_shitje' => 'required|numeric',
            'sasia'       => 'required'
        ]);
        $sasia = $request->sasia;
        $vlera_blerje = (int)$sasia * (float)$request->cmim_blerje;
        $vlera_shitje = (int)$sasia * (float)$request->cmim_shitje;
        $product = Products::create(array_merge($request->all(), ['vlera_blerje' => $vlera_blerje,'vlera_shitje'=> $vlera_shitje]));
        if ($product->id){
            $insert = DB::table('sasia')->insert(['product_id' => $product->id, 'sasia' => $sasia]);
            return response()->json(['status' => 200, 'message' => 'Produktu u shtua']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $category
     * @return \Illuminate\Http\Response
     */
    public function show($category)
    {
        $products = DB::table('products')
            ->join('sasia', 'products.id', '=', 'sasia.product_id')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->select('products.*','products.emertimi as emri', 'sasia.sasia', 'categories.emertimi')
            ->where('categories.emertimi', '=', $category)
            ->get();
        $catecories = DB::table('categories')->get();
        return view('pages.index')->with(['category' => $category, 'products' => $products, 'categories' => $catecories]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $products = DB::table('products')
            ->join('sasia', 'products.id', '=', 'sasia.product_id')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->select('products.*','products.emertimi as emri', 'sasia.sasia', 'categories.emertimi', 'categories.id as cat_id')
            ->where('products.id', '=', $id)
            ->get();
        return response($products);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required',
            'emertimi'    => 'required',
            'cmim_blerje' => 'required|numeric',
            'cmim_shitje' => 'required|numeric',
            'sasia'       => 'required'
        ]);
        $id =  $request->id;
        $sasia = $request->sasia;
        $vlera_blerje = (int)$sasia * (float)$request->cmim_blerje;
        $vlera_shitje = (int)$sasia * (float)$request->cmim_shitje;

        Products::where('id', $id)->update(array_merge($request->except('_token', 'sasia'), ['vlera_blerje' => $vlera_blerje,'vlera_shitje'=> $vlera_shitje]));
        $insert = DB::table('sasia')->where('product_id', $id)->update(['sasia' => $sasia]);
        return response()->json(['status' => 200, 'message' => 'Produktu u Editua']);

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
