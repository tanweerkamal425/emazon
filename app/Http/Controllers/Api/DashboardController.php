<?php

namespace App\Http\Controllers\Api;

use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Resources\Json\JsonResource;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $products = Product::all();
        $payments = Payment::all();
        $orders = Order::all();
        // dd($orders);

        $order_items = [];
        $category_ids = [];
        foreach ($orders as $o) {
            $items = $o->orderItems()->get();
            foreach($items as $i) {
                $product = $i->product()->first();
                $category_ids[] = $product->category_id;
            }            
        }

        $count_of_category = collect($category_ids)->countBy();
        // dd($count_of_category);

        $category_percentage = [];
        foreach ($count_of_category as $key => $value) {
            $category_percentage[] = [
                'category_name' =>  Category::find($key)->name,
                'percentage'    =>  number_format(($value * 100) / count($category_ids), 2),
            ];
        }

        // dd($category_percentage);
        

        $total_products = $products->count();

        $total_payments = $payments->count();
        $total_payment_amount = $payments->sum('amount');

        $total_orders = $orders->count();
        $total_order_amount = $orders->sum('amount');
        $total_sp = $orders->sum('gross_total');
        $total_cp = $orders->sum('subtotal');
        $profit = $total_sp - $total_cp;

        $users = User::all()->count();

        $monthlySales = DB::table('orders')
                        ->select(
                            DB::raw('YEAR(created_at) as year'), 
                            DB::raw('MONTH(created_at) as month'), 
                            DB::raw('SUM(amount) as total_sales')
                        )
                        ->groupBy(DB::raw('YEAR(created_at)'), DB::raw('MONTH(created_at)'))
                        ->get();

        $monthlyProductCounts = Product::select(
                                DB::raw('YEAR(created_at) as year'), 
                                DB::raw('MONTH(created_at) as month'), 
                                DB::raw('COUNT(*) as count')
                            )
                            ->groupBy('year', 'month')
                            ->get();
        // dd($monthlyProductCounts);   
                                        


        $data = [
            'total_products'    =>  $total_products,
            'total_payments'    =>  $total_payments,
            'total_payment_amount'  =>  $total_payment_amount,
            'total_orders'      =>  $total_orders,
            'total_order_amount'    =>  $total_order_amount,
            'users'             =>  $users,
            'profit'            =>  $profit,
            'monthly_sales'     =>  $monthlySales,
            'category_percentage'   =>  $category_percentage,
            'monthly_product_counts'    =>  $monthlyProductCounts,
        ];

        return $data;

    }
}
