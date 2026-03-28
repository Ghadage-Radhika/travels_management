<?php
// app/Models/BusTax.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class BusTax extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bus_taxes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'tax_date',
        'bus_number',
        'tax_from',
        'tax_to',
        'amount',
        'tax_image',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tax_date' => 'date',
        'tax_from' => 'date',
        'tax_to'   => 'date',
        'amount'   => 'decimal:2',
    ];

    /**
     * Mutator: Ensure bus_number is always uppercase
     */
    protected function busNumber(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => strtoupper($value),
        );
    }

    /**
     * Accessor: Format the amount to INR currency
     */
    protected function formattedAmount(): Attribute
    {
        return Attribute::make(
            get: fn () => '₹ ' . number_format($this->amount, 2),
        );
    }

    /**
     * Accessor: Get the duration in days between tax_from and tax_to
     */
    protected function duration(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->tax_from->diffInDays($this->tax_to) + 1,
        );
    }

    /**
     * Scope: Filter tax records by bus number
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $busNumber
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByBusNumber($query, $busNumber)
    {
        return $query->where('bus_number', strtoupper($busNumber));
    }

    /**
     * Scope: Filter tax records by date range
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \Illuminate\Support\Carbon|string $from
     * @param \Illuminate\Support\Carbon|string $to
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDateBetween($query, $from, $to)
    {
        return $query->whereBetween('tax_date', [$from, $to]);
    }

    /**
     * Scope: Filter tax records valid on a specific date
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \Illuminate\Support\Carbon|string $date
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeValidOnDate($query, $date)
    {
        return $query->whereDate('tax_from', '<=', $date)
                     ->whereDate('tax_to', '>=', $date);
    }

    /**
     * Get total tax amount for a specific bus
     *
     * @param string $busNumber
     * @return float
     */
    public static function getTotalByBus($busNumber)
    {
        return static::byBusNumber($busNumber)->sum('amount');
    }

    /**
     * Get total tax amount in a date range
     *
     * @param \Illuminate\Support\Carbon|string $from
     * @param \Illuminate\Support\Carbon|string $to
     * @return float
     */
    public static function getTotalBetweenDates($from, $to)
    {
        return static::dateBetween($from, $to)->sum('amount');
    }

    /**
     * Get average tax amount per bus
     *
     * @return float
     */
    public static function getAverageAmount()
    {
        return static::avg('amount') ?? 0;
    }

    /**
     * Check if a bus has valid tax on a specific date
     *
     * @param string $busNumber
     * @param \Illuminate\Support\Carbon|string $date
     * @return bool
     */
    public static function isValidOnDate($busNumber, $date)
    {
        return static::byBusNumber($busNumber)
                     ->validOnDate($date)
                     ->exists();
    }

    /**
     * Get the nearest expiring tax record for a bus
     *
     * @param string $busNumber
     * @return self|null
     */
    public static function getNearestExpiringForBus($busNumber)
    {
        return static::byBusNumber($busNumber)
                     ->whereDate('tax_to', '>=', now())
                     ->orderBy('tax_to', 'asc')
                     ->first();
    }

    /**
     * Get expired tax records
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getExpired()
    {
        return static::whereDate('tax_to', '<', now())->get();
    }

    /**
     * Get expiring soon tax records (within 30 days)
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getExpiringSoon()
    {
        return static::whereBetween('tax_to', [now(), now()->addDays(30)])->get();
    }
}