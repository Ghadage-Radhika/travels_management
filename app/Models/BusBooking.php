<?php
// app/Models/BusBooking.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusBooking extends Model
{
    protected $fillable = [
        'booking_date',
        'route_from',
        'route_to',
        'kilometer',
        'bus_number',
        'pickup_time',
        'booking_amount',
        'advance_amount',
        'remaining_amount',
        'note',
        'created_by',
    ];

    protected $casts = [
        'booking_date'     => 'date',
        'booking_amount'   => 'decimal:2',
        'advance_amount'   => 'decimal:2',
        'remaining_amount' => 'decimal:2',
        'kilometer'        => 'decimal:2',
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}