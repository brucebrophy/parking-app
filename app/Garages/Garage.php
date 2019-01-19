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
        return $this->total_spots - $this->garageUsers()->where('exited_at', null)->count();
    }

    public function getOccupiedSpotsAttribute()
    {
        return $this->garageUsers()->where('exited_at', null)->count();
    }

    public function garageUsers()
    {
        return $this->hasMany(\App\Garages\GarageUser::class);
    }

    public function garageUserCount()
    {
        return $this->garageUsers()->where('exited_at', null)->count();
    }

    public function availableSpots()
    {
        return $this->total_spots - $this->garageUsers()->where('exited_at', null)->count();
    }
}
