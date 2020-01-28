<?php

namespace App\Http\Controllers;

use App\Models\Agents;
use App\Models\CarProducts;
use App\Models\Categories;
use App\Models\Makinat;
use App\Models\Products;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CarProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Categories::all();
        $makinat = DB::table('makinat')
            ->join('agents', 'agents.id', '=', 'makinat.agent_id')
            ->select('makinat.*','agents.emri as emri', 'agents.mbiemri as mbiemri')
            ->get();

        $carProducts = DB::table('car_products')
            ->join('makinat', 'car_products.makina_id', '=', 'makinat.id')
            ->join('agents', 'makinat.agent_id', '=', 'agents.id')
            ->join('products', 'car_products.product_id', '=', 'products.id')
            ->select('car_products.*','agents.emri as emri', 'agents.mbiemri as mbiemri', 'makinat.targa as targa', 'products.emertimi', 'products.id as product_id')
            ->get();

        $dates = DB::table('car_products')
            ->select('data')
            ->groupBy('data')
            ->get();

        return view('pages.carProducts')->with([
            'categories' => $categories,
            'makinat' => $makinat,
            'carProducts' => $carProducts,
            'dates' => $dates
        ]);
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
            'product_id' => 'required|numeric',
            'makina_id' => 'required|numeric',
            'sasia' => 'required|numeric'
        ];

        $messages = [
            'required'  => ':attribute nuk mund te lihet bosh',
            'numeric'    => ':attribute nuk eshte numer',
            'unique'    => ':attribute egziston ne databaze'
        ];

        $validatedData = $request->validate($rules, $messages);
        $sasia = $request->sasia;
        $product_id = $request->product_id;
        $today = date('d-m-Y');
        if (!$request->has('data')){
            $request->request->add(['data' => $today]);
        }
        $product = DB::table('sasia')->where('product_id', '=', $product_id)->first();
        $productSasia = $product->sasia;

        if ($sasia > $productSasia){
            return redirect()->back()->withErrors(['Kujdes, nuk ka gjendje ne magazine']);
        }

        $product = CarProducts::create($request->except(['_token', 'category_id']));
        if ($product){
            DB::table('sasia')->where('product_id', '=', $product_id)->decrement('sasia',$sasia);
            return redirect()->back()->with('data', ['msg' => 'Produkti u Shtua me Sukses ne Makine']);
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

    public function showCar(Request $request, $id)
    {
        $where = [];
        if ($id){
            $where = ['makinat.id'=>$id];
        }
        if ($request->data !== 'null'){
            $where = ['car_products.data' => $request->data];
        }
        if ($request->data !== 'null' && $id){
            $where = ['car_products.data' => $request->data, 'makinat.id' => $id];
        }
        $carProducts = DB::table('car_products')
            ->join('makinat', 'car_products.makina_id', '=', 'makinat.id')
            ->join('agents', 'makinat.agent_id', '=', 'agents.id')
            ->join('products', 'car_products.product_id', '=', 'products.id')
            ->where($where)
            ->select('car_products.*','agents.emri as emri', 'agents.mbiemri as mbiemri', 'makinat.targa as targa', 'products.emertimi')
            ->get();

        return response($carProducts);
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
    public function updateSasia(Request $request)
    {
        $type = $request->type;
        if ($type == 'in'){
            $shto_product_id =$request->shto_product_id;
            $shto_item_id = $request->shto_item_id;
            $sasia_plus = $request->sasia_plus;
            $product = DB::table('sasia')->where('product_id', '=', $shto_product_id)->first();
            if ($sasia_plus > $product->sasia){
                return redirect()->back()->withErrors(['Kujdes, nuk ka gjendje ne magazine']);
            }
            DB::table('sasia')->where('product_id', '=', $shto_product_id)->decrement('sasia',$sasia_plus);
            DB::table('car_products')->where('id', '=', $shto_item_id)->increment('sasia',$sasia_plus);
            return redirect()->back()->with('data', ['msg' => 'Sasia ju Shtua Produktit']);
        }else{
            $hiq_product_id =$request->hiq_product_id;
            $hiq_item_id = $request->hiq_item_id;
            $sasia_min = $request->sasia_min;
            $item = DB::table('car_products')->where('id', '=', $hiq_item_id)->first();
            if ($sasia_min > $item->sasia){
                return redirect()->back()->withErrors(['Kujdes, Nuk mund te kthesh kete vlere']);
            }
            DB::table('sasia')->where('product_id', '=', $hiq_product_id)->increment('sasia',$sasia_min);
            DB::table('car_products')->where('id', '=', $hiq_item_id)->decrement('sasia',$sasia_min);
            return redirect()->back()->with('data', ['msg' => 'Sasia ju Hoq Produktit']);
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
        $item = DB::table('car_products')->where('id', '=', $id)->first();
        DB::table('sasia')->where('product_id', '=', $item->product_id)->increment('sasia',$item->sasia);
        CarProducts::destroy($id);
        return redirect()->back()->with('data', ['msg' => 'Produkti u Hoq nga lista']);
    }

    public function productByCategory($id)
    {
        $products = DB::table('products')
            ->where('category_id', '=', $id)
            ->get();
        return response($products);
    }

    public function generateInvoice(Request $request){
        $date = $request->data;
        $makina = $request->carId;
        $total = (float)0;
        $uniqueId = uniqid();
        $insertArray = [];
        $carProducts = DB::table('car_products')
            ->join('makinat', 'car_products.makina_id', '=', 'makinat.id')
            ->join('agents', 'makinat.agent_id', '=', 'agents.id')
            ->join('products', 'car_products.product_id', '=', 'products.id')
            ->where(['car_products.data' => $date, 'car_products.makina_id' => $makina])
            ->select("car_products.id AS id", "car_products.data AS date",  "car_products.product_id AS product_id",  "makinat.targa as car_id",  "makinat.agent_id AS agent_id",  "products.emertimi AS product_name",  "agents.emri as agent_name AS agent_name", "agents.mbiemri AS agent_surname",  "car_products.sasia as quantity",  "products.cmim_shitje as price")
            ->get();
        foreach ($carProducts as $carProduct){
            $insertArray[] = [
                'date' => $carProduct->date,
                'product_id' => $carProduct->product_id,
                'car_id' => $carProduct->car_id,
                'agent_id' => $carProduct->agent_id,
                'product_name' => $carProduct->product_name,
                'agent_name' => $carProduct->agent_name .' '. $carProduct->agent_surname,
                'quantity' => $carProduct->quantity,
                'price' => $carProduct->price,
                'value' => $carProduct->quantity * $carProduct->price,
            ];
            $agjenti = $carProduct->agent_name .' '. $carProduct->agent_surname;
            $total = $total + ($carProduct->quantity * $carProduct->price);
        }
        $insertToMemory = DB::table('fatura_shoqerimit')->insert($insertArray);
        if($insertToMemory){
            foreach ($carProducts as $carProduct){
                DB::table('car_products') ->where('id', $carProduct->id)->update(['status' => 1]);
            }
        }
        $flieName = $date.'-'.$makina.'-'.$uniqueId.'-fatura.pdf';
        $pdf = PDF::loadView('invoices.carInvoice', ['data' => $carProducts, 'date' => $date, 'agjenti' => $agjenti, 'total'=>$total]);
        $pdf->save(public_path().'/invoices/'.$flieName);
        return $pdf->stream(public_path().'/invoices/'.$flieName);
    }

    function addInvoiceItem(Request $request) {

        $id = $request->product_id;
        $rules = [
            'sasia' => 'required|numeric'
        ];
        $messages = [
            'required'  => ':attribute nuk mund te lihet bosh',
            'numeric'    => ':attribute nuk eshte numer',
            'unique'    => ':attribute egziston ne databaze'
        ];
        $validatedData = $request->validate($rules, $messages);

        $item = CarProducts::where('id', $id)->first();
        if ($item->sasia < $request->sasia){
            return redirect()->back()->withErrors(['Kujdes, Nuk sasia me e madhe se gjendja ne makine']);
        }
        $product = Products::where('id', $item->product_id)->first();
        $makinat = Makinat::where('id', $item->makina_id)->first();
        $agent = Agents::where('id', $makinat->agent_id)->first();

        $dataArray = [
            'makina_id' => $item->makina_id,
            'product_id' => $item->product_id,
            'data' => $item->data,
            'product_name' => $product->emertimi,
            'agent_name' => $agent->emri.' '.$agent->mbiemri,
            'agent_id' => $agent->id,
            'sasia' => $request->sasia,
            'cmim_blerje' => $product->cmim_blerje,
            'cmim_shitje' => $product->cmim_shitje,
            'total' => $product->cmim_shitje * $request->sasia
        ];
         $invoiceItem = DB::table('invoices_item')->where(['agent_id' => $agent->id, 'invoice_id' => null, 'product_id' => $item->product_id, 'makina_id'=>$item->makina_id])->get();
         if ($invoiceItem->count() > 0){
             $insert = DB::table('invoices_item')->where(['agent_id' => $agent->id, 'invoice_id' => null, 'product_id' => $item->product_id, 'makina_id'=>$item->makina_id])->increment('sasia', $request->sasia);
             DB::table('invoices_item')->where(['agent_id' => $agent->id, 'invoice_id' => null, 'product_id' => $item->product_id, 'makina_id'=>$item->makina_id])->update(['total' => DB::raw('sasia * cmim_shitje')]);
         }else{
             $insert = DB::table('invoices_item')->insert($dataArray);
         }
         if ($insert){
             DB::table('car_products')->where('id', '=', $id)->decrement('sasia', $request->sasia);
             return redirect()->back()->with('data', ['msg' => 'Produkti u shtua tek lista per faturim te agjentit']);
         }
    }
}
