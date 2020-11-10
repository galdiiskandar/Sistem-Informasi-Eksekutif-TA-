<?php

namespace App\Http\Controllers;

use App\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rooms = DB::table('rooms')
                    ->orderBy('room_number','asc')
                    ->get();
                    
        return view('room.index',['data_rooms' => $rooms]);
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
            'add_room_number' => 'required|min:1|digits:3,5|numeric|unique:rooms,room_number',
            'add_room_type'   => 'required',
            'add_room_status' => 'required'
        );

        $customMessages = array(
            'add_room_number.required' => 'The room number field is required.',
            'add_room_number.min'      => 'The room number must be at least value 1.',
            'add_room_number.digits'  => 'The room number must be at least 3 characters.',
            'add_room_number.numeric'  => 'The room number must be a number.',
            'add_room_number.unique'   => 'The room number already exist.',
            'add_room_type.required'   => 'The room type field is required.',
            'add_room_status.required' => 'The status field is required.'
        );

        $error = Validator::make($request->all(), $rules, $customMessages);

        if ($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        if ($request -> add_information == null){
            $add_information = '-';
        } else {
            $add_information = $request -> add_information;
        }
        
        DB::table('rooms')->insert([
            'room_number' => $request -> add_room_number,
            'room_type'   => $request -> add_room_type,
            'information' => $add_information,
            'status'      => $request -> add_room_status,
            'created_at'  => \Carbon\Carbon::now(),
            'updated_at'  => \Carbon\Carbon::now()
        ]);

        return response()->json(['success' => 'data']);
    }

    /** 
     * Display the specified resource.
     *
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function show(Room $room)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function edit(Room $room)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if ($request -> edit_information == null){
            $edit_information = '-';
        } else {
            $edit_information = $request -> edit_information;
        }

        DB::table('rooms')->where('id',$request->edit_id)->update([
            'status'      => $request -> edit_room_status,
            'information' => $request -> edit_information,
            'updated_at'  => \Carbon\Carbon::now()
        ]);
   
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('rooms')->where('id',$id)->delete();
        return back();
    }
}
