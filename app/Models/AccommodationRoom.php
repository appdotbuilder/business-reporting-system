<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\AccommodationRoom
 *
 * @property int $id
 * @property string $business_unit
 * @property string $room_number
 * @property string $room_type
 * @property float $daily_rate
 * @property int $max_occupancy
 * @property string $status
 * @property string|null $description
 * @property array|null $amenities
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|AccommodationRoom newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AccommodationRoom newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AccommodationRoom query()
 * @method static \Illuminate\Database\Eloquent\Builder|AccommodationRoom whereAmenities($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccommodationRoom whereBusinessUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccommodationRoom whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccommodationRoom whereDailyRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccommodationRoom whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccommodationRoom whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccommodationRoom whereMaxOccupancy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccommodationRoom whereRoomNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccommodationRoom whereRoomType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccommodationRoom whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccommodationRoom whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccommodationRoom available()
 * @method static \Database\Factories\AccommodationRoomFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class AccommodationRoom extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'business_unit',
        'room_number',
        'room_type',
        'daily_rate',
        'max_occupancy',
        'status',
        'description',
        'amenities',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'daily_rate' => 'decimal:2',
        'max_occupancy' => 'integer',
        'amenities' => 'array',
    ];

    /**
     * Scope a query to only include available rooms.
     */
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    /**
     * Get the business unit name in title case
     */
    public function getBusinessUnitNameAttribute(): string
    {
        return ucfirst($this->business_unit);
    }

    /**
     * Get the room type name in title case
     */
    public function getRoomTypeNameAttribute(): string
    {
        return ucwords(str_replace('_', ' ', $this->room_type));
    }
}