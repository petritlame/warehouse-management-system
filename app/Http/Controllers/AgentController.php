<?php

namespace App\Http\Controllers;

use App\Models\Agents;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            'mbiemri'    => 'required'
        ];

        $messages = [
            'required'  => ':attribute nuk mund te lihet bosh',
            'unique'    => ':attribute egziston ne databaze'
        ];
        $validatedData = $request->validate($rules, $messages);
        $agents = Agents::create($request->all());
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
        Agents::destroy($id);
        return redirect()->back()->with('data', ['msg' => 'Agjenti u Fshi me Sukses']);
    }
}
