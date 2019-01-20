<?php

namespace App\Garages;

use Illuminate\Database\Eloquent\Model;

class GarageUser extends Model
{
    protected $dates = [
        'entered_at',
        'exited_at',
    ];

    protected $casts = [
        'is_valid' => 'boolean',
    ];

    protected $fillable = [
        'ticket_number',
        'licence_number',
        'garage_id',
        'rate_id',
        'is_valid',
        'entered_at',
        'exited_at',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->generateTicket();
            $model->updateEnteredAt();
        });

        static::updating(function ($model) {
            $model->updateExitedAt();
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
