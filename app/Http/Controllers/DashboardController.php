<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    function DasboardPage():View
    {
        return view('pages.dashboard.dashboard-page');
    }

    function Summery(Request $request)
    {
        $user_id = $request->header('id');

        $product    = Product::where('user_id', $user_id)->count();
        $category   = Category::where('user_id', $user_id)->count();
        $customer   = Customer::where('user_id', $user_id)->count();
        $invoice    = Invoice::where('user_id', $user_id)->count();
        $total      = Invoice::where('user_id', $user_id)->sum('total');
        $vat        = Invoice::where('user_id', $user_id)->sum('vat');
        $payable    = Invoice::where('user_id', $user_id)->sum('payable');

        $dashboard = [
            'product'   =>  $product,
            'category'  =>  $category,
            'customer'  =>  $customer,
            'invoice'   =>  $invoice,
            'total'     =>  round($total),
            'vat'       =>  round($vat),
            'payable'   =>  round($payable)
        ];

        return $dashboard;

    }
}
