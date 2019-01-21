<?php

namespace App\Garages;

use Illuminate\Database\Eloquent\Model;

class Garage extends Model
{
    protected $fillable = [
        'total_spots',
    ];

    protected $appends = ['available_spots', 'occupied_spots'];

    public function getAvailableSpotsAttribute()
    {
        return $this->total_spots - $this->garageTicketCount();
    }

    public function getOccupiedSpotsAttribute()
    {
        return $this->tickets()->count();
    }

    public function tickets()
    {
        return $this->hasMany(\App\Garages\Ticket::class);
    }

    public function garageTicketCount()
    {
        return $this->tickets()->count();
    }

    public function availableSpots()
    {
        return $this->total_spots - $this->garageTicketCount();
    }
}
