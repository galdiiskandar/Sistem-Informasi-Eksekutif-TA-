<?php

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            [
                'product_name' => 'Lemari',
                'model' => 'Olympic',
                'information' => '-',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'product_name' => 'Lemari',
                'model' => 'Lion Star',
                'information' => '-',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'product_name' => 'Kulkas',
                'model' => 'Samsung',
                'information' => '-',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'product_name' => 'Kulkas',
                'model' => 'LG',
                'information' => '-',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'product_name' => 'TV',
                'model' => 'Polytron',
                'information' => '-',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'product_name' => 'TV',
                'model' => 'Cocoa',
                'information' => '-',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'product_name' => 'Kasur',
                'model' => 'King Koil',
                'information' => '-',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'product_name' => 'Kasur',
                'model' => 'Airland',
                'information' => '-',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'product_name' => 'Meja',
                'model' => 'UNO',
                'information' => '-',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'product_name' => 'Meja',
                'model' => 'Modera',
                'information' => '-',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'product_name' => 'Sofa',
                'model' => 'Ohama',
                'information' => '-',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'product_name' => 'Sofa',
                'model' => 'EQUI MOKU',
                'information' => '-',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'product_name' => 'AC',
                'model' => 'Sharp',
                'information' => '-',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'product_name' => 'AC',
                'model' => 'Daikin',
                'information' => '-',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ]
        ]);
    }
}
