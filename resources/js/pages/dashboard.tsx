import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem, type SharedData } from '@/types';
import { Head, usePage } from '@inertiajs/react';
import React from 'react';

interface Props {
    stats: {
        accommodation?: {
            active_guests: number;
            available_rooms: number;
            total_rooms: number;
            monthly_revenue: number;
            units?: {
                goldenkost: number;
                greendoors: number;
                divakost: number;
            };
        };
        restaurant?: {
            active_cashiers: number;
            menu_items: number;
            total_menu_items: number;
        };
        parking?: {
            active_shifts: number;
            daily_revenue: number;
            monthly_revenue: number;
        };
        expenses?: {
            pending_count: number;
            monthly_total: number;
        };
        management?: {
            total_users: number;
            active_employees: number;
            pending_payrolls: number;
        };
    };
    userRole: string;
    businessType: string | null;
    businessUnit: string | null;
    [key: string]: unknown;
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

export default function Dashboard({ stats, userRole, businessType, businessUnit }: Props) {
    const { auth } = usePage<SharedData>().props;

    const formatCurrency = (amount: number): string => {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0,
        }).format(amount);
    };

    const getRoleDisplay = (role: string): { name: string; color: string; icon: string } => {
        switch (role) {
            case 'developer':
                return { name: 'Developer', color: 'bg-red-500', icon: '👨‍💻' };
            case 'owner':
                return { name: 'Owner', color: 'bg-blue-500', icon: '👔' };
            case 'staff':
                return { name: 'Staff', color: 'bg-green-500', icon: '👨‍💼' };
            default:
                return { name: 'User', color: 'bg-gray-500', icon: '👤' };
        }
    };

    const roleInfo = getRoleDisplay(userRole);

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Dashboard" />
            <div className="space-y-6">
                {/* Header */}
                <div className="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-sm border">
                    <div className="flex items-center justify-between">
                        <div>
                            <h1 className="text-2xl font-bold text-gray-900 dark:text-white">
                                📊 Business Reports Dashboard
                            </h1>
                            <p className="text-gray-600 dark:text-gray-300 mt-1">
                                Welcome back, {auth.user?.name}
                            </p>
                        </div>
                        <div className="flex items-center gap-3">
                            <div className={`${roleInfo.color} text-white px-3 py-1 rounded-full text-sm font-medium flex items-center gap-2`}>
                                <span>{roleInfo.icon}</span>
                                {roleInfo.name}
                            </div>
                            {businessType && (
                                <div className="bg-gray-100 dark:bg-gray-700 px-3 py-1 rounded-full text-sm">
                                    {businessType}
                                    {businessUnit && ` - ${businessUnit}`}
                                </div>
                            )}
                        </div>
                    </div>
                </div>

                {/* Accommodation Stats */}
                {stats.accommodation && (
                    <div className="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-sm border">
                        <div className="flex items-center gap-2 mb-4">
                            <span className="text-2xl">🏨</span>
                            <h2 className="text-xl font-semibold text-gray-900 dark:text-white">Accommodation</h2>
                        </div>
                        <div className="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div className="text-center p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                                <div className="text-2xl font-bold text-blue-600 dark:text-blue-400">
                                    {stats.accommodation.active_guests}
                                </div>
                                <div className="text-sm text-gray-600 dark:text-gray-300">Active Guests</div>
                            </div>
                            <div className="text-center p-4 bg-green-50 dark:bg-green-900/20 rounded-lg">
                                <div className="text-2xl font-bold text-green-600 dark:text-green-400">
                                    {stats.accommodation.available_rooms}
                                </div>
                                <div className="text-sm text-gray-600 dark:text-gray-300">Available Rooms</div>
                            </div>
                            <div className="text-center p-4 bg-purple-50 dark:bg-purple-900/20 rounded-lg">
                                <div className="text-2xl font-bold text-purple-600 dark:text-purple-400">
                                    {stats.accommodation.total_rooms}
                                </div>
                                <div className="text-sm text-gray-600 dark:text-gray-300">Total Rooms</div>
                            </div>
                            <div className="text-center p-4 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg">
                                <div className="text-lg font-bold text-yellow-600 dark:text-yellow-400">
                                    {formatCurrency(stats.accommodation.monthly_revenue)}
                                </div>
                                <div className="text-sm text-gray-600 dark:text-gray-300">Monthly Revenue</div>
                            </div>
                        </div>
                        {stats.accommodation.units && (
                            <div className="mt-6">
                                <h3 className="text-lg font-medium text-gray-900 dark:text-white mb-3">Business Units</h3>
                                <div className="grid grid-cols-3 gap-4">
                                    <div className="text-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                        <div className="font-bold text-gray-900 dark:text-white">{stats.accommodation.units.goldenkost}</div>
                                        <div className="text-sm text-gray-600 dark:text-gray-300">Goldenkost</div>
                                    </div>
                                    <div className="text-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                        <div className="font-bold text-gray-900 dark:text-white">{stats.accommodation.units.greendoors}</div>
                                        <div className="text-sm text-gray-600 dark:text-gray-300">Greendoors</div>
                                    </div>
                                    <div className="text-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                        <div className="font-bold text-gray-900 dark:text-white">{stats.accommodation.units.divakost}</div>
                                        <div className="text-sm text-gray-600 dark:text-gray-300">Divakost</div>
                                    </div>
                                </div>
                            </div>
                        )}
                    </div>
                )}

                {/* Restaurant Stats */}
                {stats.restaurant && (
                    <div className="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-sm border">
                        <div className="flex items-center gap-2 mb-4">
                            <span className="text-2xl">🍽️</span>
                            <h2 className="text-xl font-semibold text-gray-900 dark:text-white">Restaurant - Joglodjawi.wg</h2>
                        </div>
                        <div className="grid grid-cols-3 gap-4">
                            <div className="text-center p-4 bg-orange-50 dark:bg-orange-900/20 rounded-lg">
                                <div className="text-2xl font-bold text-orange-600 dark:text-orange-400">
                                    {stats.restaurant.active_cashiers}
                                </div>
                                <div className="text-sm text-gray-600 dark:text-gray-300">Active Cashiers</div>
                            </div>
                            <div className="text-center p-4 bg-teal-50 dark:bg-teal-900/20 rounded-lg">
                                <div className="text-2xl font-bold text-teal-600 dark:text-teal-400">
                                    {stats.restaurant.menu_items}
                                </div>
                                <div className="text-sm text-gray-600 dark:text-gray-300">Available Items</div>
                            </div>
                            <div className="text-center p-4 bg-indigo-50 dark:bg-indigo-900/20 rounded-lg">
                                <div className="text-2xl font-bold text-indigo-600 dark:text-indigo-400">
                                    {stats.restaurant.total_menu_items}
                                </div>
                                <div className="text-sm text-gray-600 dark:text-gray-300">Total Menu Items</div>
                            </div>
                        </div>
                    </div>
                )}

                {/* Parking Stats */}
                {stats.parking && (
                    <div className="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-sm border">
                        <div className="flex items-center gap-2 mb-4">
                            <span className="text-2xl">🅿️</span>
                            <h2 className="text-xl font-semibold text-gray-900 dark:text-white">Parking - RPM Parkir</h2>
                        </div>
                        <div className="grid grid-cols-3 gap-4">
                            <div className="text-center p-4 bg-purple-50 dark:bg-purple-900/20 rounded-lg">
                                <div className="text-2xl font-bold text-purple-600 dark:text-purple-400">
                                    {stats.parking.active_shifts}
                                </div>
                                <div className="text-sm text-gray-600 dark:text-gray-300">Active Shifts</div>
                            </div>
                            <div className="text-center p-4 bg-green-50 dark:bg-green-900/20 rounded-lg">
                                <div className="text-lg font-bold text-green-600 dark:text-green-400">
                                    {formatCurrency(stats.parking.daily_revenue)}
                                </div>
                                <div className="text-sm text-gray-600 dark:text-gray-300">Today's Revenue</div>
                            </div>
                            <div className="text-center p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                                <div className="text-lg font-bold text-blue-600 dark:text-blue-400">
                                    {formatCurrency(stats.parking.monthly_revenue)}
                                </div>
                                <div className="text-sm text-gray-600 dark:text-gray-300">Monthly Revenue</div>
                            </div>
                        </div>
                    </div>
                )}

                <div className="grid md:grid-cols-2 gap-6">
                    {/* Expenses */}
                    {stats.expenses && (
                        <div className="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-sm border">
                            <div className="flex items-center gap-2 mb-4">
                                <span className="text-2xl">💰</span>
                                <h2 className="text-xl font-semibold text-gray-900 dark:text-white">Expenses</h2>
                            </div>
                            <div className="space-y-4">
                                <div className="flex items-center justify-between p-3 bg-red-50 dark:bg-red-900/20 rounded-lg">
                                    <span className="text-gray-700 dark:text-gray-300">Pending Approval</span>
                                    <span className="text-xl font-bold text-red-600 dark:text-red-400">
                                        {stats.expenses.pending_count}
                                    </span>
                                </div>
                                <div className="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <span className="text-gray-700 dark:text-gray-300">Monthly Total</span>
                                    <span className="text-lg font-bold text-gray-900 dark:text-white">
                                        {formatCurrency(stats.expenses.monthly_total)}
                                    </span>
                                </div>
                            </div>
                        </div>
                    )}

                    {/* Management (Developer only) */}
                    {stats.management && (
                        <div className="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-sm border">
                            <div className="flex items-center gap-2 mb-4">
                                <span className="text-2xl">⚙️</span>
                                <h2 className="text-xl font-semibold text-gray-900 dark:text-white">System Management</h2>
                            </div>
                            <div className="space-y-4">
                                <div className="flex items-center justify-between p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                                    <span className="text-gray-700 dark:text-gray-300">Total Users</span>
                                    <span className="text-xl font-bold text-blue-600 dark:text-blue-400">
                                        {stats.management.total_users}
                                    </span>
                                </div>
                                <div className="flex items-center justify-between p-3 bg-green-50 dark:bg-green-900/20 rounded-lg">
                                    <span className="text-gray-700 dark:text-gray-300">Active Employees</span>
                                    <span className="text-xl font-bold text-green-600 dark:text-green-400">
                                        {stats.management.active_employees}
                                    </span>
                                </div>
                                <div className="flex items-center justify-between p-3 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg">
                                    <span className="text-gray-700 dark:text-gray-300">Pending Payrolls</span>
                                    <span className="text-xl font-bold text-yellow-600 dark:text-yellow-400">
                                        {stats.management.pending_payrolls}
                                    </span>
                                </div>
                            </div>
                        </div>
                    )}
                </div>

                {/* Quick Actions */}
                <div className="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-sm border">
                    <h2 className="text-xl font-semibold text-gray-900 dark:text-white mb-4">🚀 Quick Actions</h2>
                    <div className="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <button className="p-4 text-center bg-blue-50 dark:bg-blue-900/20 hover:bg-blue-100 dark:hover:bg-blue-900/40 rounded-lg transition-colors">
                            <div className="text-2xl mb-2">📊</div>
                            <div className="text-sm font-medium text-gray-900 dark:text-white">View Reports</div>
                        </button>
                        <button className="p-4 text-center bg-green-50 dark:bg-green-900/20 hover:bg-green-100 dark:hover:bg-green-900/40 rounded-lg transition-colors">
                            <div className="text-2xl mb-2">➕</div>
                            <div className="text-sm font-medium text-gray-900 dark:text-white">Add Expense</div>
                        </button>
                        <button className="p-4 text-center bg-purple-50 dark:bg-purple-900/20 hover:bg-purple-100 dark:hover:bg-purple-900/40 rounded-lg transition-colors">
                            <div className="text-2xl mb-2">👥</div>
                            <div className="text-sm font-medium text-gray-900 dark:text-white">Manage Users</div>
                        </button>
                        <button className="p-4 text-center bg-orange-50 dark:bg-orange-900/20 hover:bg-orange-100 dark:hover:bg-orange-900/40 rounded-lg transition-colors">
                            <div className="text-2xl mb-2">⚙️</div>
                            <div className="text-sm font-medium text-gray-900 dark:text-white">Settings</div>
                        </button>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}