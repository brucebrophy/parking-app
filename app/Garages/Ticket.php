<?php

namespace App\Garages;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $casts = [
        'is_valid' => 'boolean',
    ];

    protected $fillable = [
        'ticket_number',
        'licence_number',
        'garage_id',
        'rate_id',
        'is_valid',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->generateTicketNumber();
        });
    }

    public function rate()
    {
        return $this->belongsTo(\App\Garages\Rate::class);
    }

    private function generateTicketNumber()
    {
        return $this->ticket_number = str_random(10);
    }
}
