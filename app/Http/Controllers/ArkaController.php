<?php

namespace App\Http\Controllers;

use App\Models\Arka;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ArkaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $month = date('m');
        $year = date('Y');
        $arka = DB::select("SELECT arka.*, users.name FROM arka INNER JOIN users ON arka.user_id = users.id WHERE MONTH(STR_TO_DATE(`data`, '%d-%m-%Y')) = $month AND YEAR(STR_TO_DATE(`data`, '%d-%m-%Y')) = $year");
        $gjendja = DB::select("SELECT IF(SUM(T.gjendja), SUM(T.gjendja), 0) as gjendja FROM ( SELECT SUM(`hyrjet`) - SUM(`daljet`) as gjendja FROM arka WHERE MONTH(STR_TO_DATE(`data`, '%d-%m-%Y')) = $month AND YEAR(STR_TO_DATE(`data`, '%d-%m-%Y')) = $year ) as T LIMIT 1");
        return view('pages.arka')->with(['records' => $arka, 'gjendja' => (float)$gjendja[0]->gjendja]);
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
            'data'    => 'required',
            'nr_arketimi' => 'required|numeric',
            'nr_pagese' => 'required|numeric',
            'hyrjet'       => 'required|numeric',
            'daljet'       => 'required|numeric',
        ];

        $messages = [
            'required'  => ':attribute nuk mund te lihet bosh',
            'numeric'    => ':attribute nuk eshte numer',
            'unique'    => ':attribute egziston ne databaze'
        ];

        $validatedData = $request->validate($rules, $messages);
        $newDate = date("d-m-Y", strtotime($request->data));

        $arka = DB::table('arka')->insert(
            [
                'data' => $newDate,
                'nr_arketimi' => $request->nr_arketimi,
                'nr_pagese' => $request->nr_pagese,
                'shpjegmi'=> $request->shpjegmi,
                'hyrjet'=> $request->hyrjet,
                'daljet' => $request->daljet,
                'user_id' => Auth::id()
            ]
        );
        if($arka){
            return redirect()->back()->with('data', ['msg' => 'Rekordi u Shtua me Sukses']);
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
        $year = date('Y');
        $arka = DB::select("SELECT arka.*, users.name FROM arka INNER JOIN users ON arka.user_id = users.id WHERE MONTH(STR_TO_DATE(`data`, '%d-%m-%Y')) = $id AND YEAR(STR_TO_DATE(`data`, '%d-%m-%Y')) = $year");
        $gjendja = DB::select("SELECT IF(SUM(T.gjendja), SUM(T.gjendja), 0) as gjendja FROM ( SELECT SUM(`hyrjet`) - SUM(`daljet`) as gjendja FROM arka WHERE MONTH(STR_TO_DATE(`data`, '%d-%m-%Y')) = $id AND YEAR(STR_TO_DATE(`data`, '%d-%m-%Y')) = $year ) as T LIMIT 1");
        return view('pages.arka')->with(['records' => $arka, 'gjendja' => (float)$gjendja[0]->gjendja]);
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
        //
    }
}
