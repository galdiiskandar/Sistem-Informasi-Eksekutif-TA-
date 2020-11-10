<?php

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'Rudi',
                'address' => 'Jl. Ciungwanara',
                'gender' => 'Laki-laki',
                'email' => 'owner@simplyapartment.com',
                'password' => bcrypt('ownersimply'),
                'photo' => 'default_image.png',
                'role' => 1,
                'status' => 'Active',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'Ismail',
                'address' => 'Jl. Merdeka',
                'gender' => 'Laki-laki',
                'email' => 'top-level1@simplyapartment.com',
                'password' => bcrypt('topsimply'),
                'photo' => 'default_image.png',
                'role' => 1,
                'status' => 'Active',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'Juliantara',
                'address' => 'Jl. Badak Agung I',
                'gender' => 'Laki-laki',
                'email' => 'top-level2@simplyapartment.com',
                'password' => bcrypt('topsimply'),
                'photo' => 'default_image.png',
                'role' => 1,
                'status' => 'Active',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'Galdi Satya Iskandar',
                'address' => 'Jl. Tukad Yeh Aya',
                'gender' => 'Laki-laki',
                'email' => 'galdiiskandar@gmail.com',
                'password' => bcrypt('secretsecret'),
                'photo' => 'default_image.png',
                'role' => 2,
                'status' => 'Active',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'Ayu Permatasari',
                'address' => 'Jl. Tukad Badung',
                'gender' => 'Perempuan',
                'email' => 'permatasari@gmail.com',
                'password' => bcrypt('secretsecret'),
                'photo' => 'default_image.png',
                'role' => 2,
                'status' => 'Active',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'Setiawan Nanda',
                'address' => 'Jl. Tukad Citarum',
                'gender' => 'Laki-laki',
                'email' => 'setiawan.nanda@gmail.com',
                'password' => bcrypt('secretsecret'),
                'photo' => 'default_image.png',
                'role' => 2,
                'status' => 'Inactive',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'Joko Setiawan',
                'address' => 'Jl. Tukad Musi',
                'gender' => 'Laki-laki',
                'email' => 'jokos@gmail.com',
                'password' => bcrypt('secretsecret'),
                'photo' => 'default_image.png',
                'role' => 2,
                'status' => 'Inactive',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'Nana Indah Permata',
                'address' => 'Jl. Kebo Iwa',
                'gender' => 'Perempuan',
                'email' => 'indahpermata@gmail.com',
                'password' => bcrypt('secretsecret'),
                'photo' => 'default_image.png',
                'role' => 2,
                'status' => 'Inactive',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ]
        ]);
    }
}
