<?php

namespace App\Http\Controllers;

use App\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inventory = DB::table('inventories')
        ->join('rooms', 'inventories.room_id', '=', 'rooms.id')
        ->select('inventories.*','rooms.room_number as roomnumber')
        ->get();

        $room = DB::table('rooms')->get();
        return view('inventory.index',['data_inventory' => $inventory],['data_room' => $room]);
        
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
        $validator = \Validator::make($request->all(), [
            'add_room_id' => 'required',
            'add_product_name'=> 'required',
            'add_model'=> 'required',
            'add_product_serial_number'=> 'required',
            'add_purchase_date'=> 'required',
            'add_condition'=> 'required',
            'add_qty'=> 'required',
            'add_information'=> 'required',
        ]);

        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }

        DB::table('inventories')->insert([
            'room_id' => $request -> add_room_id,
            'product_name' => $request -> add_product_name,
            'model' => $request -> add_model,
            'product_serial_number' => $request -> add_product_serial_number,
            'purchase_date' => $request -> add_purchase_date,
            'qty' => $request -> add_qty,
            'condition' => $request -> add_condition,
            'information' => $request -> add_information
        ]);

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function show(Inventory $inventory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function edit(Inventory $inventory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        DB::table('inventories')->where('id',$request->edit_id)->update([
        'room_id' => $request -> edit_room_id,
        'product_name' => $request -> edit_product_name,
        'model' => $request -> edit_model,
        'product_serial_number' => $request -> edit_product_serial_number,
        'purchase_date' => $request -> edit_purchase_date,
        'qty' => $request -> edit_qty,
        'condition' => $request -> edit_condition,
        'information' => $request -> edit_information
        ]);
   
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function destroy($inventory)
    {
        DB::table('inventories')->where('id',$inventory)->delete();
        return back();
    }
}
