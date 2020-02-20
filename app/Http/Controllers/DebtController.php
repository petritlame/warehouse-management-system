<?php

namespace App\Http\Controllers;

use App\Models\Debt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DebtController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $totalOut = 0;
        $totalIn = 0;
        $debts = Debt::all();
        $debtsTotalOut = Debt::where(['status' => 0, 'type' => 0])->get();
        $debtsTotalIn = Debt::where(['status' => 0, 'type' => 1])->get();
        foreach ($debtsTotalOut as $item){
            $totalOut = $totalOut + $item->value;
        }
        foreach ($debtsTotalIn as $item){
            $totalIn = $totalIn + $item->value;
        }
        return view('pages.debt')->with(['debts'=>$debts, 'totalDebtOut' => (float)$totalOut, 'totalDebtIn' => (float)$totalIn]);
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

    public function remove(Request $request)
    {
        $rules = [
            'value' => 'required',
            'type' => 'required',
        ];
        $messages = [
            'required' => ':attribute nuk mund te lihet bosh',
        ];
        $validatedData = $request->validate($rules, $messages);
        $id = $request->id;
        $vlera = $request->value;
        $tipi = $request->type;
        if ($tipi == 1) {
            DB::table('debt')->where('id', '=', $id)->increment('value', $vlera);
            DB::table('debt')->where('id', '=', $id)->update(['status' => 0]);
            return redirect()->back()->with('data', ['msg' => 'Borxhi u Ndryshua me Sukses']);
        } else {
            $borxhi = DB::table('debt')->where('id', '=', $id)->first();

            if ($borxhi->value < $vlera) {
                return redirect()->back()->withErrors(['Kujdes, Vlera e borxhit Total me e vogel se vlera']);
            }
            DB::table('debt')->where('id', '=', $id)->decrement('value', $vlera);
            if ($borxhi->value == $vlera) {
                DB::table('debt')->where('id', '=', $id)->update(['status' => 1]);
            }
            return redirect()->back()->with('data', ['msg' => 'Borxhi u Ndryshua me Sukses']);
        }
    }
}
