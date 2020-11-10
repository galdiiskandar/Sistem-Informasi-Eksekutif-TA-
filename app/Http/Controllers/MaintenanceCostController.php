<?php

namespace App\Http\Controllers;

use App\MaintenanceCost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use Auth;
use PDF;

class MaintenanceCostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {  
        if(($request->range != null) && ($request->add_report_type == 1))
        {
            $string = explode(' - ',$request->range);

            $date1 = $string[0];
            $date2 = $string[1];

            $date11 = \Carbon\Carbon::parse($date1)->format('Y-m-d');
            $date22 = \Carbon\Carbon::parse($date2)->format('Y-m-d');

            $maintenanceCost      = DB::table('maintenance_costs')
                                    ->join('users as u1', 'u1.id', '=', 'maintenance_costs.created_by')
                                    ->join('users as u2', 'u2.id', '=', 'maintenance_costs.updated_by')
                                    ->join('room_inventories', 'room_inventories.code_inventory', '=', 'maintenance_costs.room_inventory_id')
                                    ->join('rooms', 'rooms.id', '=', 'room_inventories.room_id')
                                    ->join('products', 'products.id', '=', 'room_inventories.product_id')
                                    ->select(
                                                'maintenance_costs.*', 
                                                'u1.name as created_by',
                                                'u2.name as updated_by', 
                                                'room_inventories.code_inventory as codeinven', 
                                                'rooms.room_number as roomnumber',
                                                'products.product_name as proname')
                                    ->where('maintenance_costs.status','Active')
                                    ->whereBetween('maintenance_costs.date_maintenance', array($date11, $date22))
                                    ->orderBy('maintenance_costs.created_at','desc')
                                    ->get();
        } else if(($request->add_date_urgency != null) && ($request->add_report_type == 2)){
            $string = explode('-',$request->add_date_urgency);

            $m = $string[0];
            $y = $string[1];

            $maintenanceCost      = DB::select("
            SELECT 
            mc.*,
            u1.name as created_by,
            u2.name as updated_by,
            r.code_inventory as codeinven,
            rm.room_number as roomnumber,
            p.product_name as proname
            FROM maintenance_costs as mc
            INNER JOIN users as u1 on mc.created_by = u1.id
            INNER JOIN users as u2 on mc.created_by = u2.id
            INNER JOIN room_inventories as r on mc.room_inventory_id = r.code_inventory 
            INNER JOIN rooms as rm on r.room_id = rm.id 
            INNER JOIN products as p on r.product_id = p.id
            INNER JOIN (
			SELECT room_inventory_id
			FROM
			maintenance_costs
			WHERE year(date_maintenance) = $y AND month(date_maintenance) = $m AND status = 'ACTIVE'
        	GROUP BY
			room_inventory_id
			HAVING
			COUNT(room_inventory_id) > 1) dup ON mc.room_inventory_id = dup.room_inventory_id
            WHERE YEAR(mc.date_maintenance) = $y AND month(date_maintenance) = $m AND mc.status = 'ACTIVE'
            ");
        } else {
            $maintenanceCost      = DB::table('maintenance_costs')
                                    ->join('users as u1', 'u1.id', '=', 'maintenance_costs.created_by')
                                    ->join('users as u2', 'u2.id', '=', 'maintenance_costs.updated_by')
                                    ->join('room_inventories', 'room_inventories.code_inventory', '=', 'maintenance_costs.room_inventory_id')
                                    ->join('rooms', 'rooms.id', '=', 'room_inventories.room_id')
                                    ->join('products', 'products.id', '=', 'room_inventories.product_id')
                                    ->select(
                                                'maintenance_costs.*', 
                                                'u1.name as created_by',
                                                'u2.name as updated_by', 
                                                'room_inventories.code_inventory as codeinven', 
                                                'rooms.room_number as roomnumber',
                                                'products.product_name as proname')
                                    ->orderBy('maintenance_costs.created_at','desc')
                                    ->get();
        }

        $roomInventory        = DB::table('room_inventories')
                                    ->join('rooms', 'room_inventories.room_id', '=', 'rooms.id')
                                    ->join('products', 'room_inventories.product_id', '=', 'products.id')
                                    ->select('room_inventories.*','rooms.room_number as roomnumber', 'products.product_name as productname')
                                    ->where('room_inventories.status','Active')
                                    ->orderBy('rooms.room_number','asc')
                                    ->get();

        return view('maintenance-cost.index',[
            'data_maintenance_costs' => $maintenanceCost, 
            'data_room_inventories' => $roomInventory,
            'data' => $request->range,
            'data1' => $request->add_date_urgency,
            'data2' => $request->add_report_type
        ]);
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
            'add_maintenance_date' => 'required',
            'add_inven_code' => 'required',
            'add_cost'       => 'required|integer|min:1',
            'add_photo'    => 'required|mimes:jpeg,bmp,png'
        );

        $customMessages = array(
            'add_maintenance_date.required' => 'The maintenance date field is required.',
            'add_inven_code.required' => 'The inventory code field is required.',
            'add_cost.required'       => 'The cost field is required.',
            'add_cost.integer'        => 'The cost field must be a number.',
            'add_cost.min'            => 'The cost field must be above zero.',
            'add_photo.required'      => 'The payment receipt is required.',
            'add_photo.mimes'         => 'File must be an image.'
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

        $image    = $request->file('add_photo');
        $new_name = rand() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('display_picture'), $new_name);

        $userID = Auth::user()->id;
        $status = 'Active';
        DB::table('maintenance_costs')->insert([
            'created_by'        => $userID,
            'updated_by'        => $userID,
            'date_maintenance'  => \Carbon\Carbon::parse($request -> add_maintenance_date)->format('Y-m-d'),
            'room_inventory_id' => $request -> add_inven_code,
            'cost'              => $request -> add_cost,
            'receipt_photo'     => $new_name,
            'information'       => $add_information,
            'status'            => $status,
            'created_at'        => \Carbon\Carbon::now(),
            'updated_at'        => \Carbon\Carbon::now()
        ]);

        return response()->json(['success' => 'data']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\MaintenanceCost  $maintenanceCost
     * @return \Illuminate\Http\Response
     */
    public function show(MaintenanceCost $maintenanceCost)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MaintenanceCost  $maintenanceCost
     * @return \Illuminate\Http\Response
     */
    public function edit(MaintenanceCost $maintenanceCost)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MaintenanceCost  $maintenanceCost
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MaintenanceCost $maintenanceCost)
    {
        if ($request -> edit_information == null){
            $edit_information = '-';
        } else {
            $edit_information = $request -> edit_information;
        }

        $userID = Auth::user()->id;
        DB::table('maintenance_costs')->where('id',$request->edit_id)->update([
            'updated_by'        => $userID,
            'information'       => $edit_information,
            'status'            => $request -> edit_status,
            'updated_at'        => \Carbon\Carbon::now()
        ]);

        return response()->json(['success' => 'data']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MaintenanceCost  $maintenanceCost
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('maintenance_costs')->where('id',$id)->delete();
        return back();
    }

    public function dashboard(Request $request)
    {
        if($request->chart_year == null)
        {
            $data_year = \Carbon\Carbon::now()->format('Y');
        }
        else{
            $data_year = $request->chart_year;
        }

        $room_number = [];
        $bulan_a = ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12"];
        $room_search = DB::table('rooms')->orderBy('room_number', 'asc')->get();

        foreach ($room_search as $key2 => $rs) {

            $room_number[$key2]['name'] = $rs->room_number;

            foreach ($bulan_a as $key => $bulan) {
                $rooms = DB::table('maintenance_costs')
                    ->join('room_inventories', 'maintenance_costs.room_inventory_id', '=', 'room_inventories.code_inventory')
                    ->join('rooms', 'rooms.id', '=', 'room_inventories.room_id')
                    ->select('rooms.room_number as room_number')
                    ->selectRaw('cast(sum(maintenance_costs.cost)as UNSIGNED) as y')
                    ->where('rooms.room_number', $rs->room_number)
                    ->where('maintenance_costs.status', 'Active')
                    ->whereMonth('maintenance_costs.date_maintenance', $bulan)
                    ->whereYear('maintenance_costs.date_maintenance', $data_year)
                    ->groupBy('rooms.room_number')
                    ->get();

                    if (@$rooms[0]->y != null) {
                        $room_number[$key2]['data'][$key] = $rooms[0]->y;
                    } else {
                        $room_number[$key2]['data'][$key]  = 0;
                    }
            }
        }
        
        $countRI = DB::table('room_inventories')
                    ->where('status', 'Active')
                    ->count();
        
        $countRIVG = DB::table('room_inventories')
                    ->where('condition','Very Good')
                    ->where('status', 'Active')
                    ->count();

        $countRIG = DB::table('room_inventories')
                    ->where('condition','Good')
                    ->where('status', 'Active')
                    ->count();

        $countRIB = DB::table('room_inventories')
                    ->where('condition','Bad')
                    ->where('status', 'Active')
                    ->count();

        return view('dashboard.index', 
            [
                'data_maintenance_costs' => $room_number,
                'data_count_RI' => $countRI,
                'data_count_RIVG' => $countRIVG,
                'data_count_RIG' => $countRIG,
                'data_count_RIB' => $countRIB,
                'data_year' => $data_year
            ]
        );
    }

    public function report(Request $request)
    {
        if($request->report_type == 1){
            $string = explode(' - ',$request->print_date);
            
            $date1 = $string[0];
            $date2 = $string[1];

            $date11 = \Carbon\Carbon::parse($date1)->format('Y-m-d');
            $date22 = \Carbon\Carbon::parse($date2)->format('Y-m-d');

            $room      = DB::table('maintenance_costs')
                                    ->join('room_inventories', 'room_inventories.code_inventory', '=', 'maintenance_costs.room_inventory_id')
                                    ->join('rooms', 'rooms.id', '=', 'room_inventories.room_id')
                                    ->select('rooms.room_number as roomnumber')
                                    ->where('maintenance_costs.status','Active')
                                    ->whereBetween('maintenance_costs.date_maintenance', array($date11, $date22))
                                    ->groupBy('rooms.room_number')
                                    ->get(); 
            
            $maintenanceCost      = DB::table('maintenance_costs')
                                    ->join('room_inventories', 'room_inventories.code_inventory', '=', 'maintenance_costs.room_inventory_id')
                                    ->join('rooms', 'rooms.id', '=', 'room_inventories.room_id')
                                    ->join('products', 'products.id', '=', 'room_inventories.product_id')
                                    ->select(
                                                'maintenance_costs.cost',
                                                'maintenance_costs.date_maintenance',
                                                'room_inventories.code_inventory as codeinven', 
                                                'rooms.room_number as roomnumber',
                                                'products.product_name as proname',
                                                'products.model as model')
                                    ->where('maintenance_costs.status','Active')
                                    ->whereBetween('maintenance_costs.date_maintenance', array($date11, $date22))
                                    ->get();

            $cost      = DB::table('maintenance_costs')
                                    ->join('room_inventories', 'room_inventories.code_inventory', '=', 'maintenance_costs.room_inventory_id')
                                    ->join('rooms', 'rooms.id', '=', 'room_inventories.room_id')
                                    ->select('rooms.room_number as roomnumber')
                                    ->selectRaw('cast(sum(maintenance_costs.cost)as UNSIGNED) as total_cost')
                                    ->where('maintenance_costs.status','Active')
                                    ->whereBetween('maintenance_costs.date_maintenance', array($date11, $date22))
                                    ->groupBy('rooms.room_number')
                                    ->get();
            $pdf = PDF::loadview('maintenance-cost.report',
            [
                'date_start' => $date11,
                'date_finish' => $date22,
                'data_room' => $room,
                'data_maintenance_costs' => $maintenanceCost, 
                'data_cost' => $cost,
                'data_type' => $request->report_type
            ]);
            return $pdf->stream();
        } else {
            $string = explode('-',$request->print_date);

            $m = $string[0];
            $y = $string[1];

            $room      = DB::select("
            SELECT 
            rm.room_number as roomnumber
            FROM maintenance_costs as mc
            INNER JOIN room_inventories as r on mc.room_inventory_id = r.code_inventory 
            INNER JOIN rooms as rm on r.room_id = rm.id 
            INNER JOIN (
			SELECT room_inventory_id
			FROM
			maintenance_costs
			WHERE year(date_maintenance) = $y AND month(date_maintenance) = $m AND status = 'ACTIVE'
        	GROUP BY
			room_inventory_id
			HAVING
			COUNT(room_inventory_id) > 1) dup ON mc.room_inventory_id = dup.room_inventory_id
            WHERE year(mc.date_maintenance) = $y AND month(mc.date_maintenance) = $m AND mc.status = 'ACTIVE'
            GROUP BY (rm.room_number)
            ");
            
            $maintenanceCost      = DB::select("
            SELECT 
            mc.room_inventory_id, 
            mc.date_maintenance, 
            mc.cost,
            r.code_inventory as codeinven,
            rm.room_number as roomnumber,
            p.product_name as proname,
            p.model as model
            FROM maintenance_costs as mc
            INNER JOIN room_inventories as r on mc.room_inventory_id = r.code_inventory 
            INNER JOIN rooms as rm on r.room_id = rm.id 
            INNER JOIN products as p on r.product_id = p.id
            INNER JOIN (
			SELECT room_inventory_id
			FROM
			maintenance_costs
			WHERE year(date_maintenance) = $y AND month(date_maintenance) = $m AND status = 'ACTIVE'
        	GROUP BY
			room_inventory_id
			HAVING
			COUNT(room_inventory_id) > 1) dup ON mc.room_inventory_id = dup.room_inventory_id
            WHERE year(mc.date_maintenance) = $y AND month(mc.date_maintenance) = $m AND mc.status = 'ACTIVE'
            ");
                
            $cost      = DB::select("
            SELECT 
            rm.room_number as roomnumber,
            SUM(mc.cost) as total_cost
            FROM maintenance_costs as mc
            INNER JOIN room_inventories as r on mc.room_inventory_id = r.code_inventory 
            INNER JOIN rooms as rm on r.room_id = rm.id 
            INNER JOIN (
			SELECT room_inventory_id
			FROM
			maintenance_costs
			WHERE year(date_maintenance) = $y AND month(date_maintenance) = $m AND status = 'ACTIVE'
        	GROUP BY
			room_inventory_id
			HAVING
			COUNT(room_inventory_id) > 1) dup ON mc.room_inventory_id = dup.room_inventory_id
            WHERE year(mc.date_maintenance) = $y AND month(mc.date_maintenance) = $m AND mc.status = 'ACTIVE'
            GROUP BY (rm.room_number)
            ");
            $pdf = PDF::loadview('maintenance-cost.report',
            [
                'm' => intval($m),
                'y' => $y,
                'data_room' => $room,
                'data_maintenance_costs' => $maintenanceCost, 
                'data_cost' => $cost,
                'data_type' => $request->report_type
            ]);
            return $pdf->stream();
        }
    }

    // public function report(Request $request)
    // {
    //         if($request->print_date == null){
    //             $date = \Carbon\Carbon::now()->format('d-m-Y').' - '.\Carbon\Carbon::now()->format('d-m-Y');
    //             $string = explode(' - ',$date);
    //         }else{
    //             $string = explode(' - ',$request->print_date);
    //         }
    //         $date1 = $string[0];
    //         $date2 = $string[1];

    //         $date11 = \Carbon\Carbon::parse($date1)->format('Y-m-d');
    //         $date22 = \Carbon\Carbon::parse($date2)->format('Y-m-d');

    //          

    //     $pdf = PDF::loadview('maintenance-cost.report',
    //             [
    //                 'date_start' => $date11,
    //                 'date_finish' => $date22,
    //                 'data_room' => $room,
    //                 'data_maintenance_costs' => $maintenanceCost, 
    //                 'data_cost' => $cost
    //             ]);
    //     return $pdf->stream();
    // }

    public function test()
    {
        
        // $room_number = [];
        // $bulan_a = ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12"];
        // $room_search = DB::table('rooms')->orderBy('room_number', 'asc')->get();

        // foreach ($room_search as $key2 => $rs) {


        //     $room_number[$key2]['name'] = $rs->room_number;

        //     foreach ($bulan_a as $key => $bulan) {
        //         $rooms = DB::table('maintenance_costs')
        //             ->join('room_inventories', 'maintenance_costs.room_inventory_id', '=', 'room_inventories.code_inventory')
        //             ->join('rooms', 'rooms.id', '=', 'room_inventories.room_id')
        //             ->select('rooms.room_number as room_number')
        //             ->selectRaw('cast(sum(maintenance_costs.cost)as UNSIGNED) as y')
        //             ->where('rooms.room_number', $rs->room_number)
        //             ->whereMonth('maintenance_costs.date_maintenance', $bulan)
        //             ->groupBy('rooms.room_number')
        //             ->get();

        //             if (@$rooms[0]->y != null) {
        //                 $room_number[$key2]['data'][$key] = $rooms[0]->y;
        //             } else {
        //                 $room_number[$key2]['data'][$key]  = 0;
        //             }
        //     }
        // }
        // dd($room_number);
        // $year = DB::select("
        //     SELECT DISTINCT(YEAR(date_maintenance)) as year FROM `maintenance_costs`
        // ");

        // $room = DB::table('rooms')
        //         ->select('room_number')
        //         ->orderBy('room_number','asc')
        //         ->get();

        // $test = DB::select("
        //     SELECT m.room_inventory_id, YEAR(m.date_maintenance) as year, sum(m.cost) as total_cost, r.code_inventory, rm.room_number 
        //     FROM `maintenance_costs` as m 
        //     inner join room_inventories as r on m.room_inventory_id = r.code_inventory 
        //     inner join rooms as rm on r.room_id = rm.id 
        //     group by rm.room_number, year
        // ");
    
        $code = 'IN'.'105';
        $last = DB::table('room_inventories')
                ->where('code_inventory', 'like', '%'.$code.'%')
                ->max('code_inventory');
    
        // $new = substr($last,-3);
        // $new +=1;
        // $after = 'IN101'.sprintf("%03d", $new);
        dd($last);
    }
}
