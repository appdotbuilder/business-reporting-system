<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Payroll
 *
 * @property int $id
 * @property int $employee_id
 * @property \Illuminate\Support\Carbon $pay_period_start
 * @property \Illuminate\Support\Carbon $pay_period_end
 * @property float $base_salary
 * @property float $overtime_hours
 * @property float $overtime_rate
 * @property float $overtime_pay
 * @property float $allowances
 * @property float $deductions
 * @property float $gross_pay
 * @property float $net_pay
 * @property \Illuminate\Support\Carbon|null $pay_date
 * @property string $status
 * @property int|null $processed_by
 * @property array|null $breakdown
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Payroll newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Payroll newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Payroll query()
 * @method static \Illuminate\Database\Eloquent\Builder|Payroll whereAllowances($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payroll whereBaseSalary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payroll whereBreakdown($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payroll whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payroll whereDeductions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payroll whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payroll whereGrossPay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payroll whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payroll whereNetPay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payroll whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payroll whereOvertimeHours($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payroll whereOvertimePay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payroll whereOvertimeRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payroll wherePayDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payroll wherePayPeriodEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payroll wherePayPeriodStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payroll whereProcessedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payroll whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payroll whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payroll draft()
 * @method static \Database\Factories\PayrollFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class Payroll extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'employee_id',
        'pay_period_start',
        'pay_period_end',
        'base_salary',
        'overtime_hours',
        'overtime_rate',
        'overtime_pay',
        'allowances',
        'deductions',
        'gross_pay',
        'net_pay',
        'pay_date',
        'status',
        'processed_by',
        'breakdown',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'pay_period_start' => 'date',
        'pay_period_end' => 'date',
        'pay_date' => 'date',
        'base_salary' => 'decimal:2',
        'overtime_hours' => 'decimal:2',
        'overtime_rate' => 'decimal:2',
        'overtime_pay' => 'decimal:2',
        'allowances' => 'decimal:2',
        'deductions' => 'decimal:2',
        'gross_pay' => 'decimal:2',
        'net_pay' => 'decimal:2',
        'breakdown' => 'array',
    ];

    /**
     * Scope a query to only include draft payrolls.
     */
    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    /**
     * Get the employee that owns this payroll
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Get the user who processed this payroll
     */
    public function processor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    /**
     * Calculate gross pay
     */
    public function calculateGrossPay(): void
    {
        $this->gross_pay = $this->base_salary + $this->overtime_pay + $this->allowances;
    }

    /**
     * Calculate net pay
     */
    public function calculateNetPay(): void
    {
        $this->net_pay = $this->gross_pay - $this->deductions;
    }

    /**
     * Get the pay period duration in days
     */
    public function getPayPeriodDaysAttribute(): int
    {
        return (int) $this->pay_period_start->diffInDays($this->pay_period_end) + 1;
    }
}