<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\AccommodationGuest;
use App\Models\AccommodationRoom;
use App\Models\RestaurantCashier;
use App\Models\RestaurantMenuItem;
use App\Models\ParkingShift;
use App\Models\Expense;
use App\Models\Employee;
use App\Models\Payroll;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create system users with different roles
        $developer = User::factory()->create([
            'name' => 'Developer User',
            'email' => 'developer@business.com',
            'role' => 'developer',
            'business_type' => null,
            'business_unit' => null,
        ]);

        $owner = User::factory()->create([
            'name' => 'Business Owner',
            'email' => 'owner@business.com',
            'role' => 'owner',
            'business_type' => null,
            'business_unit' => null,
        ]);

        // Create staff users for each business type
        $accommodationStaff = [
            User::factory()->create([
                'name' => 'Goldenkost Staff',
                'email' => 'goldenkost@business.com',
                'role' => 'staff',
                'business_type' => 'accommodation',
                'business_unit' => 'goldenkost',
            ]),
            User::factory()->create([
                'name' => 'Greendoors Staff',
                'email' => 'greendoors@business.com',
                'role' => 'staff',
                'business_type' => 'accommodation',
                'business_unit' => 'greendoors',
            ]),
            User::factory()->create([
                'name' => 'Divakost Staff',
                'email' => 'divakost@business.com',
                'role' => 'staff',
                'business_type' => 'accommodation',
                'business_unit' => 'divakost',
            ]),
        ];

        $restaurantStaff = User::factory()->create([
            'name' => 'Restaurant Staff',
            'email' => 'restaurant@business.com',
            'role' => 'staff',
            'business_type' => 'restaurant',
            'business_unit' => null,
        ]);

        $parkingStaff = User::factory()->create([
            'name' => 'Parking Staff',
            'email' => 'parking@business.com',
            'role' => 'staff',
            'business_type' => 'parking',
            'business_unit' => null,
        ]);

        // Seed Accommodation data
        $accommodationUnits = ['goldenkost', 'greendoors', 'divakost'];
        
        foreach ($accommodationUnits as $unit) {
            // Create rooms for each unit
            AccommodationRoom::factory()
                ->count(random_int(8, 12))
                ->forUnit($unit)
                ->create();
                
            // Create guests for each unit
            AccommodationGuest::factory()
                ->count(random_int(5, 15))
                ->forUnit($unit)
                ->create();
                
            // Create some active guests
            AccommodationGuest::factory()
                ->count(random_int(3, 8))
                ->active()
                ->forUnit($unit)
                ->create();
        }

        // Seed Restaurant data
        RestaurantCashier::factory()
            ->count(8)
            ->create();
            
        RestaurantMenuItem::factory()
            ->count(50)
            ->create();
            
        // Create some featured items
        RestaurantMenuItem::factory()
            ->count(8)
            ->featured()
            ->available()
            ->create();

        // Seed Parking data
        $cashiers = RestaurantCashier::active()->get();
        
        ParkingShift::factory()
            ->count(30)
            ->create()
            ->each(function ($shift) use ($cashiers) {
                $shift->update(['cashier_id' => $cashiers->random()->id]);
            });
            
        // Create some active shifts
        ParkingShift::factory()
            ->count(3)
            ->active()
            ->create()
            ->each(function ($shift) use ($cashiers) {
                $shift->update(['cashier_id' => $cashiers->random()->id]);
            });

        // Seed Expense data
        $users = User::all();
        
        // Accommodation expenses
        foreach ($accommodationUnits as $unit) {
            Expense::factory()
                ->count(random_int(10, 20))
                ->forBusiness('accommodation', $unit)
                ->create([
                    'created_by' => $users->random()->id,
                    'approved_by' => $users->whereIn('role', ['developer', 'owner'])->random()->id,
                ]);
        }
        
        // Restaurant expenses
        Expense::factory()
            ->count(random_int(15, 25))
            ->forBusiness('restaurant')
            ->create([
                'created_by' => $users->random()->id,
                'approved_by' => $users->whereIn('role', ['developer', 'owner'])->random()->id,
            ]);
            
        // Parking expenses
        Expense::factory()
            ->count(random_int(8, 15))
            ->forBusiness('parking')
            ->create([
                'created_by' => $users->random()->id,
                'approved_by' => $users->whereIn('role', ['developer', 'owner'])->random()->id,
            ]);
            
        // Create some pending expenses
        Expense::factory()
            ->count(random_int(5, 10))
            ->pending()
            ->create([
                'created_by' => $users->random()->id,
            ]);

        // Seed Employee data (for Developer features)
        foreach ($accommodationUnits as $unit) {
            Employee::factory()
                ->count(random_int(5, 8))
                ->active()
                ->forBusiness('accommodation', $unit)
                ->create();
        }
        
        Employee::factory()
            ->count(random_int(8, 12))
            ->active()
            ->forBusiness('restaurant')
            ->create();
            
        Employee::factory()
            ->count(random_int(4, 6))
            ->active()
            ->forBusiness('parking')
            ->create();

        // Seed Payroll data
        $employees = Employee::active()->get();
        
        foreach ($employees as $employee) {
            // Create 2-3 historical payrolls
            Payroll::factory()
                ->count(random_int(2, 3))
                ->paid()
                ->create([
                    'employee_id' => $employee->id,
                    'base_salary' => $employee->base_salary,
                    'processed_by' => $users->whereIn('role', ['developer', 'owner'])->random()->id,
                ]);
        }
        
        // Create some draft payrolls
        Payroll::factory()
            ->count(random_int(5, 10))
            ->draft()
            ->create([
                'employee_id' => $employees->random()->id,
            ]);

        // Create demo user
        User::factory()->create([
            'name' => 'Demo User',
            'email' => 'demo@business.com',
            'role' => 'owner',
            'business_type' => null,
            'business_unit' => null,
        ]);
    }
}