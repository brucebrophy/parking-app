<?php

namespace App\Garages;

use Illuminate\Database\Eloquent\Model;

class GarageUser extends Model
{
    protected $dates = [
        'entered_at',
        'exited_at',
    ];

    protected $fillable = [
        'rate_id',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->generateTicket();
            $model->updateEnteredAt();
        });
    }

    public function rate()
    {
        return $this->belongsTo(\App\Garages\Rate::class);
    }

    private function generateTicket()
    {
        return $this->ticket_number = str_random(5);
    }

    private function updateEnteredAt()
    {
        return $this->entered_at = now();
    }

    private function updateExitedAt()
    {
        return $this->exited_at = now();
    }
}
