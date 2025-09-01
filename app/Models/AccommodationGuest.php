<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\AccommodationGuest
 *
 * @property int $id
 * @property string $name
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $id_number
 * @property string $business_unit
 * @property string $room_number
 * @property \Illuminate\Support\Carbon $check_in
 * @property \Illuminate\Support\Carbon|null $check_out
 * @property float $daily_rate
 * @property string $status
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|AccommodationGuest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AccommodationGuest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AccommodationGuest query()
 * @method static \Illuminate\Database\Eloquent\Builder|AccommodationGuest whereBusinessUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccommodationGuest whereCheckIn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccommodationGuest whereCheckOut($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccommodationGuest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccommodationGuest whereDailyRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccommodationGuest whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccommodationGuest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccommodationGuest whereIdNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccommodationGuest whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccommodationGuest whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccommodationGuest wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccommodationGuest whereRoomNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccommodationGuest whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccommodationGuest whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccommodationGuest active()
 * @method static \Database\Factories\AccommodationGuestFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class AccommodationGuest extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'id_number',
        'business_unit',
        'room_number',
        'check_in',
        'check_out',
        'daily_rate',
        'status',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'check_in' => 'date',
        'check_out' => 'date',
        'daily_rate' => 'decimal:2',
    ];

    /**
     * Scope a query to only include active guests.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Get the total amount for the stay
     */
    public function getTotalAmountAttribute(): float
    {
        if (!$this->check_out) {
            return 0;
        }
        
        $days = $this->check_in->diffInDays($this->check_out);
        return $days * $this->daily_rate;
    }

    /**
     * Get the number of days stayed
     */
    public function getDaysStayedAttribute(): int
    {
        if (!$this->check_out) {
            return (int) $this->check_in->diffInDays(now());
        }
        
        return (int) $this->check_in->diffInDays($this->check_out);
    }
}