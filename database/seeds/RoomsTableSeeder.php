<?php

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rooms')->insert([
            [
                'room_number' => '101',
                'room_type' => 'Double',
                'status' => 'Ready',
                'information' => '-',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'room_number' => '102',
                'room_type' => 'Double',
                'status' => 'Ready',
                'information' => '-',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'room_number' => '103',
                'room_type' => 'Single',
                'status' => 'Ready',
                'information' => '-',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'room_number' => '104',
                'room_type' => 'Single',
                'status' => 'Ready',
                'information' => '-',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'room_number' => '105',
                'room_type' => 'Single',
                'status' => 'Ready',
                'information' => '-',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'room_number' => '106',
                'room_type' => 'Single',
                'status' => 'Ready',
                'information' => '-',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'room_number' => '107',
                'room_type' => 'Single',
                'status' => 'Ready',
                'information' => '-',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'room_number' => '108',
                'room_type' => 'Single',
                'status' => 'Ready',
                'information' => '-',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'room_number' => '109',
                'room_type' => 'Double',
                'status' => 'Not ready',
                'information' => '-',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'room_number' => '110',
                'room_type' => 'Single',
                'status' => 'Not ready',
                'information' => '-',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ]
        ]);
    }
}
