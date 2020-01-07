<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = DB::table('categories')->get();
        return view('pages.categories', ['categories' => $categories]);
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
            'emertimi'    => 'required|unique:categories',
        ];

        $messages = [
            'required'  => ':attribute nuk mund te lihet bosh',
            'unique'    => ':attribute egziston ne databaze'
        ];
        $validatedData = $request->validate($rules, $messages);
        $categories = Categories::create($request->all());
        if ($categories){
            return redirect()->back()->with('data', ['msg' => 'Kategoria u shtua']);
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
        $categories = DB::table('categories')->where('id', '=', $id)->get();
        return response($categories);
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
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $rules = [
            'emertimi'    => 'required|unique:categories',
        ];

        $messages = [
            'required'  => ':attribute nuk mund te lihet bosh',
            'unique'    => ':attribute egziston ne databaze'
        ];

        $validatedData = $request->validate($rules, $messages);
        Categories::where('id', $request->id)->update(['emertimi' => $request->emertimi]);
        return redirect()->back()->with('data', ['msg' => 'Kategoria u Editua me Sukses']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $check = DB::table('products')->where('category_id', '=', $id)->get();
        if(count($check) > 0) {
            return redirect()->back()->withErrors(['Kujdes, kjo kategori ka produkte ne magazine']);
        }else{
            $res=Categories::where('id',$id)->delete();
            if ($res){
                return redirect()->back()->with('data', ['msg' => 'Kategoria u Fshi me sukses']);
            }
        }
    }
}
