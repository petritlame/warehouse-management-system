<?php

namespace App\Http\Controllers;

use App\Models\Clients;
use Illuminate\Http\Request;

class ClientsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Clients::all();
        return view('pages.clients')->with(['clients' => $clients]);
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
        ];

        $messages = [
            'required'  => ':attribute nuk mund te lihet bosh',
            ];
        $validatedData = $request->validate($rules, $messages);
       $client = Clients::create($request->all());
       if ($client){
           return redirect()->back()->with('data', ['msg' => 'Klienti u Shtua me Sukses']);
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
        $clients = Clients::where('id', $id)->first();
        return response($clients);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {

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
        ];

        $messages = [
            'required'  => ':attribute nuk mund te lihet bosh',
        ];
        $validatedData = $request->validate($rules, $messages);
        $updateArray = [
            'emri' => $request->emri,
            'adressa' => $request->adressa,
            'phone' => $request->phone,
            'pershkrimi' => $request->pershkrimi,
            'produktet' => $request->produktet,
            'nipt' => $request->nipt,
        ];
        $clients = Clients::find($request->id)->update($updateArray);
        if ($clients){
            return redirect()->back()->with('data', ['msg' => 'Klienti u Editua me Sukses']);
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
        Clients::destroy($id);
        return redirect()->back()->with('data', ['msg' => 'Klienti u Fshi me Sukses']);
    }

    function getProducts($id){
        $clients = Clients::where('id', $id)->first();
        $products = explode(',',$clients->produktet);
        return response($products);
    }
}
