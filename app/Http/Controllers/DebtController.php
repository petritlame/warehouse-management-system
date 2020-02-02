<?php

namespace App\Http\Controllers;

use App\Models\Debt;
use Illuminate\Http\Request;

class DebtController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $total = 0;
        $debts = Debt::all();
        $debtsTotal = Debt::where('status', 0)->get();
        foreach ($debtsTotal as $item){
            $total = $total + $item->value;
        }
        return view('pages.debt')->with(['debts'=>$debts, 'totalDebt' => (float)$total]);
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
            'value'    => 'required',
        ];
        $messages = [
            'required'  => ':attribute nuk mund te lihet bosh',
        ];
        $validatedData = $request->validate($rules, $messages);
        $debt = Debt::create($request->all());
        if ($debt){
            return redirect()->back()->with('data', ['msg' => 'Borxhi u Shtua me Sukses']);
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
        $debt = Debt::destroy($id);
        if ($debt){
            return redirect()->back()->with('data', ['msg' => 'Borxhi u Fshi     me Sukses']);
        }
    }
    public function clear($id){
        $clear = Debt::find($id)->update(['status' => 1]);
        if ($clear){
            return redirect()->back()->with('data', ['msg' => 'Borxhi u Ndryshua me Sukses']);
        }
    }
}
