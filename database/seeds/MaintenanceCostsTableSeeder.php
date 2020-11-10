<?php

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaintenanceCostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Start point of our date range.
        $start = strtotime("01 January 2018");
 
        //End point of our date range.
        $end = strtotime("20 January 2020");

        for($i = 1; $i <= 1300; $i++){
            $userID = rand(4,8);
            $timestamp = mt_rand($start, $end);
            $date_maintenance = date("Y-m-d", $timestamp);
            $times = date("Y-m-d H:M:S", $timestamp);
            $room = rand(101,108);
            $inven = rand(1,11);
            $invenCode = "IN".$room;
            $ci = $invenCode.sprintf("%03d", $inven);
            $rp = "0".rand(1,9).".jpeg";
            $cost = rand(25000,125000);
            $information = "-";

            DB::table('maintenance_costs')->insert([
                'created_by'        => $userID,
                'updated_by'        => $userID,
                'date_maintenance'  => $date_maintenance,
                'room_inventory_id' => $ci,
                'cost'              => $cost,
                'receipt_photo'     => $rp,
                'information'       => $information,
                'status'            => "Active",
                'created_at'        => $times,
                'updated_at'        => $times
            ]);
        }
    }
}
