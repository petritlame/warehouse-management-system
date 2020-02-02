<?php

namespace App\Http\Controllers;

use App\Models\Rroga;
use Illuminate\Http\Request;

class RrogaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rrogat = Rroga::all();
        return view('pages.rrogat')->with(['rrogat' => $rrogat]);
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
            'punonjesi'    => 'required',
            'shuma'    => 'required',
            'data'    => 'required',
        ];
        $messages = [
            'required'  => ':attribute nuk mund te lihet bosh',
        ];
        $validatedData = $request->validate($rules, $messages);
        $rroga = Rroga::create($request->all());
        if ($rroga){
            return redirect()->back()->with('data', ['msg' => 'Rroga u Shtua me Sukses']);
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
        $rroga = Rroga::destroy($id);
        if ($rroga){
            return redirect()->back()->with('data', ['msg' => 'Rroga u Fshi me Sukses']);
        }
    }
}
