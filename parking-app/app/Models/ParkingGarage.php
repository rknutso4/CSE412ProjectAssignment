<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
#[Fillable(['latitude',
            'longitude',
            'total_floors',
            'total_parking_spaces_per_floor',
            'total_parking_spaces',
            'total_available_parking_spaces',])]
class ParkingGarage extends Model
{
    public function ParkingGarageFloors()
    {
        return $this->hasMany(ParkingGarageFloor::Class);
    }
}