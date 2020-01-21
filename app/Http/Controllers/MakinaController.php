<?php

namespace App\Http\Controllers;

use App\Models\Makinat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MakinaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $makinat = DB::table('makinat')
        ->join('agents', 'agents.id', '=', 'makinat.agent_id')
            ->select('makinat.*','agents.emri as emri', 'agents.mbiemri as mbiemri')
            ->get();
        $agents = DB::table('agents')->get();
        return view('pages.makinat', ['makinat' => $makinat, 'agents' => $agents]);
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
            'targa'    => 'required',
            'sqarim'    => 'required',
            'agent_id' =>  'required|unique:makinat'
        ];

        $messages = [
            'required'  => ':attribute nuk mund te lihet bosh',
            'unique'    => ':attribute egziston ne databaze'
        ];
        $validatedData = $request->validate($rules, $messages);
        $agents = Makinat::create($request->all());
        if ($agents){
            return redirect()->back()->with('data', ['msg' => 'Makina u shtua']);
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
        Makinat::destroy($id);
        return redirect()->back()->with('data', ['msg' => 'Makina u Fshi me Sukses']);
    }
}
