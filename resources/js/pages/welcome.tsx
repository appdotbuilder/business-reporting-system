import { type SharedData } from '@/types';
import { Head, Link, usePage } from '@inertiajs/react';

export default function Welcome() {
    const { auth } = usePage<SharedData>().props;

    return (
        <>
            <Head title="Business Reports - Multi-Unit Management System">
                <link rel="preconnect" href="https://fonts.bunny.net" />
                <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
            </Head>
            <div className="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-gray-900 dark:to-gray-800">
                {/* Navigation */}
                <nav className="flex items-center justify-between p-6 lg:px-8">
                    <div className="flex items-center gap-2">
                        <div className="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                            <span className="text-white font-bold text-lg">📊</span>
                        </div>
                        <span className="text-xl font-bold text-gray-900 dark:text-white">Business Reports</span>
                    </div>
                    <div className="flex items-center gap-4">
                        {auth.user ? (
                            <Link
                                href={route('dashboard')}
                                className="bg-blue-600 text-white px-6 py-2 rounded-lg font-medium hover:bg-blue-700 transition-colors"
                            >
                                Dashboard
                            </Link>
                        ) : (
                            <>
                                <Link
                                    href={route('login')}
                                    className="text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white px-4 py-2 rounded-lg font-medium transition-colors"
                                >
                                    Log in
                                </Link>
                                <Link
                                    href={route('register')}
                                    className="bg-blue-600 text-white px-6 py-2 rounded-lg font-medium hover:bg-blue-700 transition-colors"
                                >
                                    Get Started
                                </Link>
                            </>
                        )}
                    </div>
                </nav>

                {/* Hero Section */}
                <div className="max-w-7xl mx-auto px-6 lg:px-8 py-12">
                    <div className="text-center mb-16">
                        <h1 className="text-5xl font-bold text-gray-900 dark:text-white mb-6">
                            🏢 Business Reporting System
                        </h1>
                        <p className="text-xl text-gray-600 dark:text-gray-300 max-w-3xl mx-auto leading-relaxed">
                            Comprehensive management solution for Accommodation, Restaurant, and Parking businesses. 
                            Streamline operations with role-based access and detailed reporting.
                        </p>
                    </div>

                    {/* Business Types */}
                    <div className="grid md:grid-cols-3 gap-8 mb-16">
                        <div className="bg-white dark:bg-gray-800 rounded-xl p-8 shadow-lg border border-gray-200 dark:border-gray-700">
                            <div className="text-4xl mb-4">🏨</div>
                            <h3 className="text-2xl font-bold text-gray-900 dark:text-white mb-4">Accommodation</h3>
                            <ul className="space-y-2 text-gray-600 dark:text-gray-300">
                                <li>• Guest Management (CRUD)</li>
                                <li>• Room Management System</li>
                                <li>• Occupancy Reports</li>
                                <li>• Multi-unit Support</li>
                                <li className="font-semibold text-blue-600">Units: Goldenkost, Greendoors, Divakost</li>
                            </ul>
                        </div>

                        <div className="bg-white dark:bg-gray-800 rounded-xl p-8 shadow-lg border border-gray-200 dark:border-gray-700">
                            <div className="text-4xl mb-4">🍽️</div>
                            <h3 className="text-2xl font-bold text-gray-900 dark:text-white mb-4">Restaurant</h3>
                            <ul className="space-y-2 text-gray-600 dark:text-gray-300">
                                <li>• Cashier Management</li>
                                <li>• Menu Item Control</li>
                                <li>• POS Integration Ready</li>
                                <li>• Expense Tracking</li>
                                <li className="font-semibold text-green-600">For: Joglodjawi.wg</li>
                            </ul>
                        </div>

                        <div className="bg-white dark:bg-gray-800 rounded-xl p-8 shadow-lg border border-gray-200 dark:border-gray-700">
                            <div className="text-4xl mb-4">🅿️</div>
                            <h3 className="text-2xl font-bold text-gray-900 dark:text-white mb-4">Parking</h3>
                            <ul className="space-y-2 text-gray-600 dark:text-gray-300">
                                <li>• Shift Revenue Reports</li>
                                <li>• Vehicle Breakdown Tracking</li>
                                <li>• Cashier Assignment</li>
                                <li>• Daily/Monthly Reports</li>
                                <li className="font-semibold text-purple-600">For: RPM Parkir</li>
                            </ul>
                        </div>
                    </div>

                    {/* Role-Based Features */}
                    <div className="bg-white dark:bg-gray-800 rounded-xl p-8 shadow-lg border border-gray-200 dark:border-gray-700 mb-16">
                        <h2 className="text-3xl font-bold text-gray-900 dark:text-white mb-8 text-center">
                            👥 Role-Based Access Control
                        </h2>
                        <div className="grid md:grid-cols-3 gap-6">
                            <div className="text-center">
                                <div className="w-16 h-16 bg-red-100 dark:bg-red-900 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <span className="text-2xl">👨‍💻</span>
                                </div>
                                <h3 className="text-xl font-bold text-gray-900 dark:text-white mb-2">Developer</h3>
                                <p className="text-gray-600 dark:text-gray-300 text-sm">
                                    Full system access including user management, employee records, and payroll processing
                                </p>
                            </div>
                            <div className="text-center">
                                <div className="w-16 h-16 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <span className="text-2xl">👔</span>
                                </div>
                                <h3 className="text-xl font-bold text-gray-900 dark:text-white mb-2">Owner</h3>
                                <p className="text-gray-600 dark:text-gray-300 text-sm">
                                    Access to all business operations, reports, and employee management features
                                </p>
                            </div>
                            <div className="text-center">
                                <div className="w-16 h-16 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <span className="text-2xl">👨‍💼</span>
                                </div>
                                <h3 className="text-xl font-bold text-gray-900 dark:text-white mb-2">Staff</h3>
                                <p className="text-gray-600 dark:text-gray-300 text-sm">
                                    Limited access to assigned business unit operations and basic reporting
                                </p>
                            </div>
                        </div>
                    </div>

                    {/* Key Features */}
                    <div className="text-center mb-12">
                        <h2 className="text-3xl font-bold text-gray-900 dark:text-white mb-8">
                            ⚡ Powerful Features
                        </h2>
                        <div className="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                            <div className="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700">
                                <div className="text-2xl mb-3">📈</div>
                                <h3 className="font-semibold text-gray-900 dark:text-white">Real-time Reports</h3>
                                <p className="text-sm text-gray-600 dark:text-gray-300 mt-2">Live business analytics and performance metrics</p>
                            </div>
                            <div className="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700">
                                <div className="text-2xl mb-3">🏗️</div>
                                <h3 className="font-semibold text-gray-900 dark:text-white">Multi-Unit Support</h3>
                                <p className="text-sm text-gray-600 dark:text-gray-300 mt-2">Separate data for each accommodation unit</p>
                            </div>
                            <div className="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700">
                                <div className="text-2xl mb-3">💰</div>
                                <h3 className="font-semibold text-gray-900 dark:text-white">Expense Tracking</h3>
                                <p className="text-sm text-gray-600 dark:text-gray-300 mt-2">Complete expense management with approvals</p>
                            </div>
                            <div className="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700">
                                <div className="text-2xl mb-3">📊</div>
                                <h3 className="font-semibold text-gray-900 dark:text-white">PostgreSQL Ready</h3>
                                <p className="text-sm text-gray-600 dark:text-gray-300 mt-2">Enterprise-grade database support</p>
                            </div>
                        </div>
                    </div>

                    {/* Call to Action */}
                    <div className="text-center">
                        <div className="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl p-8 shadow-lg">
                            <h2 className="text-3xl font-bold text-white mb-4">
                                Ready to Transform Your Business Management? 🚀
                            </h2>
                            <p className="text-xl text-blue-100 mb-8 max-w-2xl mx-auto">
                                Get started with comprehensive reporting and management tools designed for multi-unit operations.
                            </p>
                            {auth.user ? (
                                <Link
                                    href={route('dashboard')}
                                    className="bg-white text-blue-600 px-8 py-4 rounded-lg font-bold text-lg hover:bg-blue-50 transition-colors inline-block"
                                >
                                    Go to Dashboard →
                                </Link>
                            ) : (
                                <div className="flex gap-4 justify-center">
                                    <Link
                                        href={route('register')}
                                        className="bg-white text-blue-600 px-8 py-4 rounded-lg font-bold text-lg hover:bg-blue-50 transition-colors"
                                    >
                                        Create Account
                                    </Link>
                                    <Link
                                        href={route('login')}
                                        className="border-2 border-white text-white px-8 py-4 rounded-lg font-bold text-lg hover:bg-white hover:text-blue-600 transition-colors"
                                    >
                                        Sign In
                                    </Link>
                                </div>
                            )}
                        </div>
                    </div>

                    {/* Footer */}
                    <footer className="mt-16 text-center text-gray-600 dark:text-gray-400">
                        <p>Built with ❤️ using Laravel, PostgreSQL, and modern web technologies</p>
                    </footer>
                </div>
            </div>
        </>
    );
}