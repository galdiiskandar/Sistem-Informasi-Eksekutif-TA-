<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $fillable = [
        'room_id',
        'product_name',
        'model',
        'product_serial_number',
        'purchase_date',
        'qty','condition',
        'information',
    ];

    public function rooms(){
    	return $this->belongTo(Room::class, 'room_id');
    }
}
