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
        $rules = [
            'emertimi'    => 'required|unique:products',
            'cmim_blerje' => 'required|numeric',
            'cmim_shitje' => 'required|numeric',
            'sasia'       => 'required'
        ];

        $messages = [
            'required'  => ':attribute nuk mund te lihet bosh',
            'numeric'    => ':attribute nuk eshte numer',
            'unique'    => ':attribute egziston ne databaze'
        ];

        $validatedData = $request->validate($rules, $messages);
        $sasia = $request->sasia;
        $vlera_blerje = (int)$sasia * (float)$request->cmim_blerje;
        $vlera_shitje = (int)$sasia * (float)$request->cmim_shitje;
        $product = Products::create(array_merge($request->all(), ['vlera_blerje' => $vlera_blerje,'vlera_shitje'=> $vlera_shitje]));
        if ($product->id){
            $insert = DB::table('sasia')->insert(['product_id' => $product->id, 'sasia' => $sasia]);
            return redirect()->back()->with('data', ['msg' => 'Produktu u shtua']);
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
        $rules = [
            'id' => 'required',
            'emertimi'    => 'required',
            'cmim_blerje' => 'required|numeric',
            'cmim_shitje' => 'required|numeric',
            'sasia'       => 'required'
        ];
        $messages = [
            'required'  => ':attribute nuk mund te lihet bosh',
            'numeric'    => ':attribute nuk eshte numer'
        ];

        $validatedData = $request->validate($rules, $messages);

        $id =  $request->id;
        $sasia = $request->sasia;
        $vlera_blerje = (int)$sasia * (float)$request->cmim_blerje;
        $vlera_shitje = (int)$sasia * (float)$request->cmim_shitje;

        Products::where('id', $id)->update(array_merge($request->except('_token', 'sasia'), ['vlera_blerje' => $vlera_blerje,'vlera_shitje'=> $vlera_shitje]));
        $insert = DB::table('sasia')->where('product_id', $id)->update(['sasia' => $sasia]);
        return redirect()->back()->with('data', ['msg' => 'Produkti u Editua me Sukses']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $res=Products::where('id',$id)->delete();
        if ($res){
            DB::table('sasia')->where('product_id', '=', $id)->delete();
            return redirect()->back()->with('data', ['msg' => 'Produkti u Fshi me sukses']);
        }
    }
}
