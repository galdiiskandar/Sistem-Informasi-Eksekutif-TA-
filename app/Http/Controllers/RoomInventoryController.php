<?php

namespace App\Http\Controllers;

use App\RoomInventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use PDF;

class RoomInventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = $request->search_room_id;
        if($data == null){
            $roomInventories = DB::table('room_inventories')
                                ->join('rooms', 'room_inventories.room_id', '=', 'rooms.id')
                                ->join('products', 'room_inventories.product_id', '=', 'products.id')
                                ->select('room_inventories.*','rooms.room_number as roomnumber', 'products.product_name as productname')
                                ->orderBy('room_inventories.code_inventory','asc')
                                ->get();
        }
        else {
            $roomInventories = DB::table('room_inventories')
                                ->join('rooms', 'room_inventories.room_id', '=', 'rooms.id')
                                ->join('products', 'room_inventories.product_id', '=', 'products.id')
                                ->select('room_inventories.*','rooms.room_number as roomnumber', 'products.product_name as productname')
                                ->where('rooms.room_number',$data)
                                ->where('room_inventories.status','Active')
                                ->orderBy('room_inventories.code_inventory','asc')
                                ->get();
        }

        $rooms    = DB::table('rooms')
                        ->orderBy('room_number','asc')
                        ->get();
                        
        $products = DB::table('products')
                        ->orderBy('product_name','asc')
                        ->get();

        return view('roominventory.index',['data_room_inventories' => $roomInventories,'data_rooms' => $rooms,'data_products' => $products, 'data' => $data]);
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
        $rules = array(
            'add_room_id'        => 'required',
            'add_product_id'     => 'required',
            'add_product_serial' => 'required',
            'add_purchase_date'  => 'required',
            'add_condition'      => 'required'
        );

        $customMessages = array(
            'add_room_id.required'        => 'The room number field is required.',
            'add_product_id.required'     => 'The product name field is required.',
            'add_product_serial.required' => 'The product serial number field is required.',
            'add_purchase_date.required'  => 'The purchase date field is required.',
            'add_condition.required'      => 'The condition must be choosed.'
        );

        $error = Validator::make($request->all(), $rules, $customMessages);

        if ($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $room = DB::table('rooms')
                ->where('id',$request->add_room_id)
                ->value('room_number');

        $code = 'IN'.$room;
        $last = DB::table('room_inventories')
                ->where('code_inventory', 'like', '%'.$code.'%')
                ->max('code_inventory');

        if($last == null)
        {
            $code_inventories = $code.'001';
        } else {
            $new = substr($last,-3);
            $new +=1;
            $code_inventories = $code.sprintf("%03d", $new);
        }

        if ($request -> add_information == null){
            $add_information = '-';
        } else {
            $add_information = $request -> add_information;
        }
        
        DB::table('room_inventories')->insert([
            'code_inventory'        => $code_inventories,
            'room_id'               => $request -> add_room_id,
            'product_id'            => $request -> add_product_id,
            'product_serial_number' => $request -> add_product_serial,
            'purchase_date'         => \Carbon\Carbon::parse($request -> add_purchase_date)->format('Y-m-d'),
            'condition'             => $request -> add_condition,
            'information'           => $add_information,
            'status'                => $request -> add_status,
            'created_at'            => \Carbon\Carbon::now(),
            'updated_at'            => \Carbon\Carbon::now()
        ]);

        return response()->json(['success' => 'data']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RoomInventory  $roomInventory
     * @return \Illuminate\Http\Response
     */
    public function show(RoomInventory $roomInventory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RoomInventory  $roomInventory
     * @return \Illuminate\Http\Response
     */
    public function edit(RoomInventory $roomInventory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RoomInventory  $roomInventory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RoomInventory $roomInventory)
    {
        $rules = array(
            'edit_product_serial' => 'required',
            'edit_purchase_date'  => 'required',
            'edit_condition'      => 'required'
        );

        $customMessages = array(
            'edit_product_serial.required'          => 'The product serial number field is required.',
            'edit_purchase_date.required'           => 'The purchase date field is required.',
            'edit_condition.required'               => 'The condition must be choosed.'
        );

        $error = Validator::make($request->all(), $rules, $customMessages);

        if ($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        if ($request -> edit_information == null){
            $edit_information = '-';
        } else {
            $edit_information = $request -> edit_information;
        }
        
        DB::table('room_inventories')->where('code_inventory',$request->edit_code_inventory)->update([
            'product_serial_number' => $request -> edit_product_serial,
            'purchase_date'         => $request -> edit_purchase_date,
            'condition'             => $request -> edit_condition,
            'information'           => $edit_information,
            'status'                => $request -> edit_status,
            'updated_at'            => \Carbon\Carbon::now()
        ]);

        return response()->json(['success' => 'data']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RoomInventory  $roomInventory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('room_inventories')->where('code_inventory',$id)->delete();
        return back();
    }

    public function report(Request $request)
    {
        if($request->print_room_id != null)
        {
            $room = DB::select("
                SELECT rm.room_number as roomnumber
                FROM `room_inventories` as ri
                inner join rooms as rm on ri.room_id = rm.id
                where rm.room_number = $request->print_room_id AND ri.status = 'Active'
                group by rm.room_number
            ");
                    
    	    $roomInventories = DB::table('room_inventories')
                               ->join('rooms', 'room_inventories.room_id', '=', 'rooms.id')
                               ->join('products', 'room_inventories.product_id', '=', 'products.id')
                               ->select('room_inventories.*','rooms.room_number as roomnumber', 'products.product_name as productname', 'products.model as model')
                               ->where('rooms.room_number',$request->print_room_id)
                               ->where('room_inventories.status','Active')
                               ->orderBy('room_inventories.code_inventory','asc')
                               ->get();
        } else {
            $room = DB::select("
                SELECT rm.room_number as roomnumber
                FROM `room_inventories` as ri
                inner join rooms as rm on ri.room_id = rm.id
                where ri.status = 'Active' 
                group by rm.room_number
            ");
                    
    	    $roomInventories = DB::table('room_inventories')
                               ->join('rooms', 'room_inventories.room_id', '=', 'rooms.id')
                               ->join('products', 'room_inventories.product_id', '=', 'products.id')
                               ->select('room_inventories.*','rooms.room_number as roomnumber', 'products.product_name as productname', 'products.model as model')
                               ->where('room_inventories.status','Active')
                               ->orderBy('room_inventories.code_inventory','asc')
                               ->get();
        }
        $pdf = PDF::loadview('roominventory.report',[
            'data_room_inventory'=>$roomInventories,
            'data_room'=>$room
        ]);
        return $pdf->stream();
    }
}
