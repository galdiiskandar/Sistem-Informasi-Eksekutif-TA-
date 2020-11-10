<?php

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomInventoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Start point of our date range.
        $start = strtotime("01 July 2017");
 
        //End point of our date range.
        $end = strtotime("31 December 2017");

        $a=array("Very good","Good","Bad");

        for($i=1; $i<=125; $i++){
            $roomID = rand(1,8);
            $productID = rand(1,14);
            $serialNumber = Str::random(10);
            $timestamp = mt_rand($start, $end);
            $date_purchase = date("Y-m-d", $timestamp);
            $times = date("Y-m-d H:M:S", $timestamp);
            $random_keys=array_rand($a,2);
            $condition=$a[$random_keys[0]];

            $room = DB::table('rooms')
                ->where('id',$roomID)
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

            DB::table('room_inventories')->insert([
                    'code_inventory' => $code_inventories,
                    'room_id' => $roomID,
                    'product_id' => $productID,
                    'product_serial_number' => strtoupper($serialNumber),
                    'purchase_date' => $date_purchase,
                    'condition' => $condition,
                    'information' => '-',
                    'status' => 'Active',
                    'created_at' => $times,
                    'updated_at' => $times
            ]);
        }
    }
}
