<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Brand;
use App\Models\Category;
use App\Models\NewsletterSubscriber;
use App\Models\Order;
use App\Models\ProductReview;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Stripe\Review;

class AdminController extends Controller
{
    public function dashboard()
    {
        $todaysOrder = Order::whereDate('created_at', Carbon::today())->count();
        $todaysPendingOrder = Order::whereDate('created_at', Carbon::today())
            ->where('order_status', 'pending')->count();
        $totalOrders = Order::count();
        $ordenesPagas = Order::where('payment_status', 1)
            ->where('order_status', '!=', 'delivered')
            ->count();
        $pendientesDePago = Order::where('payment_status', 0)->count();
        $totalPendingOrders = Order::where('order_status', 'pending')->count();
        $totalCanceledOrders = Order::where('order_status', 'canceled')->count();
        $totalCompleteOrders = Order::where('order_status', 'delivered')->count();
        $totalProductQty = Order::sum('product_qty');

        $todaysEarnings = Order::where('order_status', '!=', 'canceled')
            ->where('payment_status', 1)
            ->whereDate('created_at', Carbon::today())
            ->sum('sub_total');

        $weekStart = now()->subWeek();
        $weekEnd = now();

        $monthStart = Carbon::now()->startOfMonth();
        $monthEnd = Carbon::now()->endOfMonth();

        $yearStart = Carbon::now()->startOfYear();
        $yearEnd = Carbon::now()->endOfYear();

        $weekEarnings = Order::where('order_status', '!=', 'canceled')
            ->where('payment_status', 1)
            ->whereBetween('created_at', [$weekStart, $weekEnd])
            ->sum('sub_total');

        $monthEarnings = Order::where('order_status', '!=', 'canceled')
            ->where('payment_status', 1)
            ->whereBetween('created_at', [$monthStart, $monthEnd])
            ->sum('sub_total');

        $yearEarnings = Order::where('order_status', '!=', 'canceled')
            ->where('payment_status', 1)
            ->whereBetween('created_at', [$yearStart, $yearEnd])
            ->sum('sub_total');

        $totalOrdersAmount = Order::where('order_status', '!=', 'canceled')
            ->where('payment_status', 1)
            ->sum('sub_total');

        $totalReview = ProductReview::count();

        $totalBrands = Brand::count();
        $totalCategories = Category::count();
        $totalBlogs = Blog::count();
        $totalSubscriber = NewsletterSubscriber::count();
        $totalVendors = User::where('role', 'vendor')->count();
        $totalUsers = User::where('role', 'user')->count();

        // Períodos anteriores para comparar

        $yesterdayEarnings = Order::where('order_status', '!=', 'canceled')
            ->where('payment_status', 1)
            ->whereDate('created_at', Carbon::now()->subDays(1)->toDateString())
            ->sum('sub_total');

        $lastWeekEarnings = Order::where('order_status', '!=', 'canceled')
            ->where('payment_status', 1)
            ->whereBetween('created_at', [$weekStart->copy()->subWeek(), $weekEnd->copy()->subWeek()])
            ->sum('sub_total');

        $lastMonthEarnings = Order::where('order_status', '!=', 'canceled')
            ->where('payment_status', 1)
            ->whereBetween('created_at', [$monthStart->copy()->subMonth(), $monthEnd->copy()->subMonth()])
            ->sum('sub_total');

        $lastYearEarnings = Order::where('order_status', '!=', 'canceled')
            ->where('payment_status', 1)
            ->whereBetween('created_at', [$yearStart->copy()->subYear(), $yearEnd->copy()->subYear()])
            ->sum('sub_total');

        $salesData = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i)->toDateString();

            $dailySales = Order::where('order_status', '!=', 'canceled')
                ->where('payment_status', 1)
                ->whereDate('created_at', $date)
                ->sum('sub_total');

            $salesData[] = $dailySales;
        }


        return view('admin.dashboard', compact(
            'todaysOrder',
            'todaysPendingOrder',
            'totalOrders',
            'totalOrdersAmount',
            'totalPendingOrders',
            'totalCanceledOrders',
            'totalCompleteOrders',
            'todaysEarnings',
            'monthEarnings',
            'yearEarnings',
            'totalReview',
            'totalBrands',
            'totalCategories',
            'totalBlogs',
            'totalSubscriber',
            'totalVendors',
            'totalUsers',
            'weekEarnings',
            'yesterdayEarnings',
            'lastWeekEarnings',
            'lastMonthEarnings',
            'lastYearEarnings',
            'salesData',
            'ordenesPagas',
            'pendientesDePago',
            'totalProductQty',
        ));
    }

    public function login()
    {
        return view('admin.auth.login');
    }
}
