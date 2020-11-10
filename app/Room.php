<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
    	'room_number',
    	'room_type',
    ];

    public function inventory(){
    	return $this->hasMany(Inventory::class, 'room_id');
    }
}
