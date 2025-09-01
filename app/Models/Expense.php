<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Expense
 *
 * @property int $id
 * @property string $business_type
 * @property string|null $business_unit
 * @property string $category
 * @property string $description
 * @property float $amount
 * @property \Illuminate\Support\Carbon $expense_date
 * @property string|null $receipt_number
 * @property string|null $vendor_name
 * @property string $payment_method
 * @property string $status
 * @property int $created_by
 * @property int|null $approved_by
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Expense newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Expense newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Expense query()
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereApprovedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereBusinessType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereBusinessUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereExpenseDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereReceiptNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereVendorName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense pending()
 * @method static \Database\Factories\ExpenseFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class Expense extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'business_type',
        'business_unit',
        'category',
        'description',
        'amount',
        'expense_date',
        'receipt_number',
        'vendor_name',
        'payment_method',
        'status',
        'created_by',
        'approved_by',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'amount' => 'decimal:2',
        'expense_date' => 'date',
    ];

    /**
     * Scope a query to only include pending expenses.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Get the user who created this expense
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who approved this expense
     */
    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Get the business type name in title case
     */
    public function getBusinessTypeNameAttribute(): string
    {
        return ucfirst($this->business_type);
    }

    /**
     * Get the category name in title case
     */
    public function getCategoryNameAttribute(): string
    {
        return ucwords(str_replace('_', ' ', $this->category));
    }

    /**
     * Get the payment method name in title case
     */
    public function getPaymentMethodNameAttribute(): string
    {
        return ucwords(str_replace('_', ' ', $this->payment_method));
    }
}