<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\RestaurantCashier
 *
 * @property int $id
 * @property string $name
 * @property string $employee_id
 * @property string|null $email
 * @property string|null $phone
 * @property \Illuminate\Support\Carbon $hire_date
 * @property string $shift
 * @property float $hourly_rate
 * @property string $status
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|RestaurantCashier newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RestaurantCashier newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RestaurantCashier query()
 * @method static \Illuminate\Database\Eloquent\Builder|RestaurantCashier whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RestaurantCashier whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RestaurantCashier whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RestaurantCashier whereHireDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RestaurantCashier whereHourlyRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RestaurantCashier whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RestaurantCashier whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RestaurantCashier whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RestaurantCashier wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RestaurantCashier whereShift($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RestaurantCashier whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RestaurantCashier whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RestaurantCashier active()
 * @method static \Database\Factories\RestaurantCashierFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class RestaurantCashier extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'employee_id',
        'email',
        'phone',
        'hire_date',
        'shift',
        'hourly_rate',
        'status',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'hire_date' => 'date',
        'hourly_rate' => 'decimal:2',
    ];

    /**
     * Scope a query to only include active cashiers.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Get parking shifts for this cashier
     */
    public function parkingShifts(): HasMany
    {
        return $this->hasMany(ParkingShift::class, 'cashier_id');
    }

    /**
     * Get the shift name in title case
     */
    public function getShiftNameAttribute(): string
    {
        return ucfirst($this->shift);
    }
}