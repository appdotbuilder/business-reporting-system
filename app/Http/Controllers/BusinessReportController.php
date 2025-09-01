<?php

namespace App\Http\Controllers;

use App\Models\AccommodationGuest;
use App\Models\AccommodationRoom;
use App\Models\RestaurantCashier;
use App\Models\RestaurantMenuItem;
use App\Models\ParkingShift;
use App\Models\Expense;
use App\Models\Employee;
use App\Models\Payroll;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class BusinessReportController extends Controller
{
    /**
     * Display the main dashboard.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get dashboard statistics based on user role and permissions
        $stats = $this->getDashboardStats($user);
        
        return Inertia::render('dashboard', [
            'stats' => $stats,
            'userRole' => $user->role,
            'businessType' => $user->business_type,
            'businessUnit' => $user->business_unit,
        ]);
    }

    /**
     * Get dashboard statistics based on user permissions
     */
    protected function getDashboardStats($user): array
    {
        $stats = [];

        // For developers and owners - show all business statistics
        if ($user->hasFullAccess()) {
            $stats['accommodation'] = [
                'active_guests' => AccommodationGuest::active()->count(),
                'available_rooms' => AccommodationRoom::available()->count(),
                'total_rooms' => AccommodationRoom::count(),
                'monthly_revenue' => AccommodationGuest::where('check_in', '>=', now()->startOfMonth())
                    ->where('status', '!=', 'cancelled')
                    ->sum('daily_rate'),
                'units' => [
                    'goldenkost' => AccommodationGuest::where('business_unit', 'goldenkost')->active()->count(),
                    'greendoors' => AccommodationGuest::where('business_unit', 'greendoors')->active()->count(),
                    'divakost' => AccommodationGuest::where('business_unit', 'divakost')->active()->count(),
                ]
            ];

            $stats['restaurant'] = [
                'active_cashiers' => RestaurantCashier::active()->count(),
                'menu_items' => RestaurantMenuItem::available()->count(),
                'total_menu_items' => RestaurantMenuItem::count(),
            ];

            $stats['parking'] = [
                'active_shifts' => ParkingShift::active()->count(),
                'daily_revenue' => ParkingShift::whereDate('shift_date', today())->sum('total_revenue'),
                'monthly_revenue' => ParkingShift::where('shift_date', '>=', now()->startOfMonth())->sum('total_revenue'),
            ];

            $stats['expenses'] = [
                'pending_count' => Expense::pending()->count(),
                'monthly_total' => Expense::where('expense_date', '>=', now()->startOfMonth())->sum('amount'),
            ];

            if ($user->isDeveloper()) {
                $stats['management'] = [
                    'total_users' => User::count(),
                    'active_employees' => Employee::active()->count(),
                    'pending_payrolls' => Payroll::draft()->count(),
                ];
            }
        } else {
            // Staff users see only their business unit data
            if ($user->business_type === 'accommodation' && $user->business_unit) {
                $stats['accommodation'] = [
                    'active_guests' => AccommodationGuest::where('business_unit', $user->business_unit)->active()->count(),
                    'available_rooms' => AccommodationRoom::where('business_unit', $user->business_unit)->available()->count(),
                    'monthly_revenue' => AccommodationGuest::where('business_unit', $user->business_unit)
                        ->where('check_in', '>=', now()->startOfMonth())
                        ->where('status', '!=', 'cancelled')
                        ->sum('daily_rate'),
                ];
            }

            if ($user->business_type === 'restaurant') {
                $stats['restaurant'] = [
                    'active_cashiers' => RestaurantCashier::active()->count(),
                    'menu_items' => RestaurantMenuItem::available()->count(),
                ];
            }

            if ($user->business_type === 'parking') {
                $stats['parking'] = [
                    'active_shifts' => ParkingShift::active()->count(),
                    'daily_revenue' => ParkingShift::whereDate('shift_date', today())->sum('total_revenue'),
                ];
            }

            $stats['expenses'] = [
                'pending_count' => Expense::where('business_type', $user->business_type)
                    ->where('business_unit', $user->business_unit)
                    ->pending()
                    ->count(),
            ];
        }

        return $stats;
    }
}