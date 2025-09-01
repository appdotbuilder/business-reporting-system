<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\RestaurantMenuItem
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string|null $description
 * @property string $category
 * @property float $price
 * @property float|null $cost
 * @property bool $available
 * @property bool $featured
 * @property string|null $image_path
 * @property array|null $ingredients
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|RestaurantMenuItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RestaurantMenuItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RestaurantMenuItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|RestaurantMenuItem whereAvailable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RestaurantMenuItem whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RestaurantMenuItem whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RestaurantMenuItem whereCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RestaurantMenuItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RestaurantMenuItem whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RestaurantMenuItem whereFeatured($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RestaurantMenuItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RestaurantMenuItem whereImagePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RestaurantMenuItem whereIngredients($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RestaurantMenuItem whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RestaurantMenuItem wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RestaurantMenuItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RestaurantMenuItem available()
 * @method static \Illuminate\Database\Eloquent\Builder|RestaurantMenuItem featured()
 * @method static \Database\Factories\RestaurantMenuItemFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class RestaurantMenuItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'code',
        'description',
        'category',
        'price',
        'cost',
        'available',
        'featured',
        'image_path',
        'ingredients',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'decimal:2',
        'cost' => 'decimal:2',
        'available' => 'boolean',
        'featured' => 'boolean',
        'ingredients' => 'array',
    ];

    /**
     * Scope a query to only include available items.
     */
    public function scopeAvailable($query)
    {
        return $query->where('available', true);
    }

    /**
     * Scope a query to only include featured items.
     */
    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    /**
     * Get the category name in title case
     */
    public function getCategoryNameAttribute(): string
    {
        return ucwords(str_replace('_', ' ', $this->category));
    }

    /**
     * Get the profit margin
     */
    public function getProfitMarginAttribute(): float
    {
        if (!$this->cost) {
            return 0;
        }
        
        return (($this->price - $this->cost) / $this->cost) * 100;
    }
}