<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BusMaintenance extends Model
{
    use HasFactory;

    protected $fillable = [
        'maintenance_date',
        'bus_number',
        'maintenance_type',
        'custom_type',        // ← NEW: free-text when type = "Other"
        'description',
        'amount_paid',
        'vendor_name',
        'tier_image',         // ← NEW: path to tier/tyre image
        'bill_image',         // ← NEW: path to bill/receipt image
        'created_by',
    ];

    protected $casts = [
        'maintenance_date' => 'date',
        'amount_paid'      => 'decimal:2',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Accessor: return the display label for maintenance type.
     * If the stored type is "Other", fall back to the free-text custom_type.
     */
    public function getDisplayTypeAttribute(): string
    {
        return $this->maintenance_type === 'Other'
            ? ($this->custom_type ?: 'Other')
            : $this->maintenance_type;
    }

    // ── Scopes for search & sort ──────────────────────────────────────────────

    /**
     * Full-text search across bus number, type, custom_type, vendor, description.
     */
    public function scopeSearch($query, ?string $term)
    {
        if (!$term) return $query;
        return $query->where(function ($q) use ($term) {
            $q->where('bus_number',       'like', "%{$term}%")
              ->orWhere('maintenance_type','like', "%{$term}%")
              ->orWhere('custom_type',     'like', "%{$term}%")
              ->orWhere('vendor_name',     'like', "%{$term}%")
              ->orWhere('description',     'like', "%{$term}%");
        });
    }

    /**
     * Sort by an allowed column + direction.
     * Falls back to latest() for unknown columns.
     */
    public function scopeSortBy($query, ?string $column, ?string $direction = 'desc')
    {
        $allowed   = ['maintenance_date', 'bus_number', 'maintenance_type', 'amount_paid', 'vendor_name'];
        $direction = strtolower($direction) === 'asc' ? 'asc' : 'desc';
        $column    = in_array($column, $allowed) ? $column : 'maintenance_date';
        return $query->orderBy($column, $direction);
    }
}