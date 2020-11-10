<?php

namespace App\Http\Controllers;

use App\Bendungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BendunganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rooms = DB::table('bendungans')
                    ->orderBy('kode_bendungan','asc')
                    ->get();
                    
        return view('bendungan.index',['data_bendungan' => $rooms]);
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
        DB::table('bendungans')->insert([
            'kode_bendungan' => $request -> add_kode_bendungan,
            'nama_bendungan' => $request -> add_nama_bendungan,
            'wilayah' => $request -> add_wilayah,
            'luas' => $request -> add_luas,
            'tanggal_dibangun' => \Carbon\Carbon::parse($request -> add_tanggal_dibangun)->format('Y-m-d')
        ]);

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Bendungan  $bendungan
     * @return \Illuminate\Http\Response
     */
    public function show(Bendungan $bendungan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Bendungan  $bendungan
     * @return \Illuminate\Http\Response
     */
    public function edit(Bendungan $bendungan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Bendungan  $bendungan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bendungan $bendungan)
    {
        DB::table('bendungans')->where('kode_bendungan',$request->edit_kode_bendungan)->update([
            'nama_bendungan' => $request -> edit_nama_bendungan,
            'wilayah' => $request -> edit_wilayah,
            'luas' => $request -> edit_luas,
            'tanggal_dibangun' => \Carbon\Carbon::parse($request -> edit_tanggal_dibangun)->format('Y-m-d')
        ]);
       
            return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Bendungan  $bendungan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('bendungans')->where('kode_bendungan',$id)->delete();
        return back();
    }
}
