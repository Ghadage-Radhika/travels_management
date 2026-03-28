<?php
// app/Models/BillingRecord.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillingRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'bus_booking_id',
        'rate_per_km',
        'diesel_amount',
        'toll_parking',
        'online_permit',
        'driver_amount',
        'other_expenses',
        'driver_name',
        'driver_mobile',
        'description',
        'total_expenses',
        'net_profit',
        'created_by',
    ];

    protected $casts = [
        'rate_per_km'    => 'decimal:2',
        'diesel_amount'  => 'decimal:2',
        'toll_parking'   => 'decimal:2',
        'online_permit'  => 'decimal:2',
        'driver_amount'  => 'decimal:2',
        'other_expenses' => 'decimal:2',
        'total_expenses' => 'decimal:2',
        'net_profit'     => 'decimal:2',
    ];

    /*
    |----------------------------------------------------------------------
    | Relationships
    |----------------------------------------------------------------------
    */
    public function booking()
    {
        return $this->belongsTo(BusBooking::class, 'bus_booking_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /*
    |----------------------------------------------------------------------
    | Helpers
    |----------------------------------------------------------------------
    */

    /**
     * Recalculate and save total_expenses + net_profit from the related booking.
     */
    public function recalculate(): void
    {
        $expenses = ($this->diesel_amount  ?? 0)
                  + ($this->toll_parking   ?? 0)
                  + ($this->online_permit  ?? 0)
                  + ($this->driver_amount  ?? 0)
                  + ($this->other_expenses ?? 0);

        $this->total_expenses = $expenses;

        if ($this->booking) {
            $this->net_profit = $this->booking->booking_amount - $expenses;
        }

        $this->save();
    }
}