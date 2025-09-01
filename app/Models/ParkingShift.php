<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\ParkingShift
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon $shift_date
 * @property string $shift_type
 * @property int|null $cashier_id
 * @property string $start_time
 * @property string|null $end_time
 * @property float $opening_balance
 * @property float|null $closing_balance
 * @property float $total_revenue
 * @property int $total_vehicles
 * @property array|null $vehicle_breakdown
 * @property string $status
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|ParkingShift newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ParkingShift newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ParkingShift query()
 * @method static \Illuminate\Database\Eloquent\Builder|ParkingShift whereCashierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParkingShift whereClosingBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParkingShift whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParkingShift whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParkingShift whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParkingShift whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParkingShift whereOpeningBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParkingShift whereShiftDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParkingShift whereShiftType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParkingShift whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParkingShift whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParkingShift whereTotalRevenue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParkingShift whereTotalVehicles($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParkingShift whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParkingShift whereVehicleBreakdown($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParkingShift active()
 * @method static \Database\Factories\ParkingShiftFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class ParkingShift extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'shift_date',
        'shift_type',
        'cashier_id',
        'start_time',
        'end_time',
        'opening_balance',
        'closing_balance',
        'total_revenue',
        'total_vehicles',
        'vehicle_breakdown',
        'status',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'shift_date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'opening_balance' => 'decimal:2',
        'closing_balance' => 'decimal:2',
        'total_revenue' => 'decimal:2',
        'total_vehicles' => 'integer',
        'vehicle_breakdown' => 'array',
    ];

    /**
     * Scope a query to only include active shifts.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Get the cashier that belongs to this shift
     */
    public function cashier(): BelongsTo
    {
        return $this->belongsTo(RestaurantCashier::class, 'cashier_id');
    }

    /**
     * Get the shift type name in title case
     */
    public function getShiftTypeNameAttribute(): string
    {
        return ucfirst($this->shift_type);
    }

    /**
     * Get the net revenue (closing - opening balance)
     */
    public function getNetRevenueAttribute(): float
    {
        if (!$this->closing_balance) {
            return 0;
        }
        
        return $this->closing_balance - $this->opening_balance;
    }
}