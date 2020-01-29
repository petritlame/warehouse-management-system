<?php

namespace App\Http\Controllers;

use App\Models\Agents;
use App\Models\Makinat;
use App\User;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AgentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $agents = DB::table('agents')->get();
        return view('pages.agents', ['agents' => $agents]);
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
            'emri'    => 'required',
            'mbiemri'    => 'required',
            'password'    => 'required'
        ];

        $messages = [
            'required'  => ':attribute nuk mund te lihet bosh',
            'unique'    => ':attribute egziston ne databaze'
        ];
        $validatedData = $request->validate($rules, $messages);

        $user = new User();
        $user->password = Hash::make($request->password);
        $user->email = strtolower($request->emri).'@ecoalcleaning.al';
        $user->name = $request->emri;
        $user->save();

        $agents = Agents::create(array_merge($request->all(), ['user_id' => $user->id]));
        if ($agents){
            return redirect()->back()->with('data', ['msg' => 'Agjenti u shtua']);
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
        $agent = DB::table('agents')->where('id', '=', $id)->get();
        return response($agent);
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
    public function update(Request $request)
    {
        $rules = [
            'emri'    => 'required',
            'mbiemri'    => 'required'
        ];

        $messages = [
            'required'  => ':attribute nuk mund te lihet bosh',
            'unique'    => ':attribute egziston ne databaze'
        ];
        $validatedData = $request->validate($rules, $messages);
        Agents::where('id', $request->id)->update($request->except('_token'));
        return redirect()->back()->with('data', ['msg' => 'Agjenti u Editua me Sukses']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $agent = Agents::where('id', $id)->first();
        User::destroy($agent->user_id);
        Agents::destroy($id);
        return redirect()->back()->with('data', ['msg' => 'Agjenti u Fshi me Sukses']);
    }

    public function singleAgent($id){
        if(Auth::user()->type == 1) {
            $agentTotal = 0;
            $agent = Agents::where('id', $id)->first();
            $invoiceItem = DB::table('invoices_item')->where(['agent_id' => $agent->id, 'invoice_id' => null])->get();
            $invoices = DB::table('invoice')->where(['agent_id' => $agent->id])->get();
            foreach ($invoices as $invoice) {
                $agentTotal = $agentTotal + $invoice->total;
            }
            return view('pages.singleAgent')->with([
                'agentName' => $agent->emri . ' ' . $agent->mbiemri,
                'invoiceItem' => $invoiceItem,
                'agent_id' => $agent->id,
                'invoices' => $invoices,
                'agentTotal' => (float)$agentTotal
            ]);
        }else{
            $agentTotal = 0;
            $agent = Agents::where('user_id', Auth::id())->first();
            $invoiceItem = DB::table('invoices_item')->where(['agent_id' => $agent->id, 'invoice_id' => null])->get();
            $invoices = DB::table('invoice')->where(['agent_id' => $agent->id])->get();
            foreach ($invoices as $invoice) {
                $agentTotal = $agentTotal + $invoice->total;
            }
            return view('pages.singleAgent')->with([
                'agentName' => $agent->emri . ' ' . $agent->mbiemri,
                'invoiceItem' => $invoiceItem,
                'agent_id' => $agent->id,
                'invoices' => $invoices,
                'agentTotal' => (float)$agentTotal
            ]);
        }
    }

    public function generateInvoice($id){
        $date = date('d-m-Y');
        $agent = Agents::where('id', $id)->first();
        $agjenti = $agent->emri .' '. $agent->mbiemri;
        $makina = Makinat::where('agent_id', $agent->id)->first();
        $total = 0;
        $invoiceItem = DB::table('invoices_item')->where(['agent_id' => $id])->get();
        foreach ($invoiceItem as $item){
            $total = $total + $item->total;
        }
        $uniqueId = uniqid();
        $flieName = $date.'-'.$agent->emri.'-'.$uniqueId.'-fatura.pdf';
        $invoice = DB::table('invoice')->insertGetId(['data' => $date, 'agent_id' => $agent->id, 'makina_id' => $makina->id, 'total' => $total, 'invoice' => $flieName]);
        foreach ($invoiceItem as $item){
            DB::table('invoices_item')->where(['id' => $item->id])->update(['invoice_id' => $invoice]);
        }

        $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true]);
        $pdf->loadView('invoices.salesInvoice', ['data' => $invoiceItem, 'date' => $date, 'agjenti' => $agjenti, 'total'=>$total]);
        $pdf->save(public_path().'/invoices/salesInvoices/'.$flieName);
        return redirect()->back()->with('data', ['msg' => 'Fatura u Gjenerua me Sukses']);
    }
}
