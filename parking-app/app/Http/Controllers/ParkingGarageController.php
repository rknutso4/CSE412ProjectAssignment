<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ParkingGarage;
use App\Models\ParkingGarageFloor;

class ParkingGarageController extends Controller
{
    public function store(Request $request)
    {
        $parkingGarage = new ParkingGarage;
        $parkingGarage->latitude = $request->integer('latitude');
        $parkingGarage->longitude = $request->integer('longitude');
        $parkingGarage->total_floors = $request->integer('total_floors');
        $parkingGarage->total_parking_spaces_per_floor = $request->integer('total_parking_spaces_per_floor');
        $parkingGarage->total_parking_spaces = $request->integer('total_parking_spaces_per_floor') * $request->integer('total_floors');
        $parkingGarage->total_available_parking_spaces = $request->integer('total_parking_spaces');
        $parkingGarage->save();
        for($i=0;$i<$parkingGarage->total_floors; $i++){
            $parkingGarageFloor = new ParkingGarageFloor;
            $parkingGarageFloor->ParkingGarage()->associate($parkingGarage);
            $parkingGarageFloor->total_parking_spaces = $request->integer('total_parking_spaces_per_floor');
            $parkingGarageFloor->total_available_parking_spaces = $request->integer('total_parking_spaces_per_floor');
            $parkingGarageFloor->save();
            
        }
        return redirect()->back()->with('success', 'Parking Garage created.');
    }
}

