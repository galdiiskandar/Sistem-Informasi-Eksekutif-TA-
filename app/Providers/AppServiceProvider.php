<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use View;
use DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        
        $maintenanceCost      = count(DB::select("
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
			WHERE year(date_maintenance) = 2020 AND status = 'ACTIVE'
        	GROUP BY
			room_inventory_id
			HAVING
			COUNT(room_inventory_id) > 1) dup ON mc.room_inventory_id = dup.room_inventory_id
            WHERE YEAR(mc.date_maintenance) = 2020 AND mc.status = 'ACTIVE'
            GROUP BY
			room_inventory_id
            "));
        
        $data = [
            'urgency' => $maintenanceCost
        ];
        \View::share('notification', $data);
    }
}
