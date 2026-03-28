<?php
// app/Models/BusInsurance.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class BusInsurance extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bus_insurances';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'insurance_date',
        'bus_number',
        'amount',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'insurance_date' => 'date',
        'amount'         => 'decimal:2',
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
     * Scope: Filter insurance records by bus number
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
     * Scope: Filter insurance records by date range
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \Illuminate\Support\Carbon|string $from
     * @param \Illuminate\Support\Carbon|string $to
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDateBetween($query, $from, $to)
    {
        return $query->whereBetween('insurance_date', [$from, $to]);
    }

    /**
     * Scope: Filter insurance records by year
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $year
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByYear($query, $year)
    {
        return $query->whereYear('insurance_date', $year);
    }

    /**
     * Scope: Filter insurance records by month and year
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $month
     * @param int $year
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByMonthYear($query, $month, $year)
    {
        return $query->whereYear('insurance_date', $year)
                     ->whereMonth('insurance_date', $month);
    }

    /**
     * Get total insurance amount for a specific bus
     *
     * @param string $busNumber
     * @return float
     */
    public static function getTotalByBus($busNumber)
    {
        return static::byBusNumber($busNumber)->sum('amount');
    }

    /**
     * Get total insurance amount in a date range
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
     * Get total insurance amount for a specific year
     *
     * @param int $year
     * @return float
     */
    public static function getTotalByYear($year)
    {
        return static::byYear($year)->sum('amount');
    }

    /**
     * Get average insurance amount
     *
     * @return float
     */
    public static function getAverageAmount()
    {
        return static::avg('amount') ?? 0;
    }

    /**
     * Get count of unique buses with insurance records
     *
     * @return int
     */
    public static function getUniqueBusCount()
    {
        return static::distinct('bus_number')->count('bus_number');
    }

    /**
     * Get insurance records grouped by bus number with totals
     *
     * @return \Illuminate\Support\Collection
     */
    public static function groupedByBus()
    {
        return static::selectRaw('bus_number, COUNT(*) as record_count, SUM(amount) as total_amount')
                     ->groupBy('bus_number')
                     ->orderByRaw('SUM(amount) DESC')
                     ->get();
    }

    /**
     * Get insurance records for a specific bus in date range
     *
     * @param string $busNumber
     * @param \Illuminate\Support\Carbon|string $from
     * @param \Illuminate\Support\Carbon|string $to
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getForBusInRange($busNumber, $from, $to)
    {
        return static::byBusNumber($busNumber)
                     ->dateBetween($from, $to)
                     ->latest('insurance_date')
                     ->get();
    }

    /**
     * Get the latest insurance record for a bus
     *
     * @param string $busNumber
     * @return self|null
     */
    public static function getLatestForBus($busNumber)
    {
        return static::byBusNumber($busNumber)
                     ->latest('insurance_date')
                     ->first();
    }

    /**
     * Check if a bus has any insurance records
     *
     * @param string $busNumber
     * @return bool
     */
    public static function existsForBus($busNumber)
    {
        return static::byBusNumber($busNumber)->exists();
    }
}