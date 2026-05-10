<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ParkingGarageFloor extends Model
{
    public function ParkingGarage()
    {
        return $this->belongsTo(ParkingGarage::Class);
    }
}
