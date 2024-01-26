<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Invoice;
use App\Models\InvoiceProduct;
use App\Models\Customer;
use Exception;

class InvoiceController extends Controller
{
    function InvoicePage():View
    {
        return view('pages.dashboard.invoice-page');
    }

    function SalePage():View
    {
        return view('pages.dashboard.sale-page');
    }

    function invoiceCreate(Request $request)
    {
        DB::beginTransaction();

        try{
            $user_id    = $request->header('id');
            $total      = $request->input('total');
            $discount   = $request->input('discount');
            $vat        = $request->input('vat');
            $payable    = $request->input('payable');

            $customer_id = $request->input('customer_id');

            $invoice = Invoice::create([
                'total'         =>  $total,
                'discount'      =>  $discount,
                'vat'           =>  $vat,
                'payable'       =>  $payable,
                'user_id'       =>  $user_id,
                'customer_id'   =>  $customer_id
            ]);

            $invoice_id = $invoice->id;
            $products   = $request->input('products');

            foreach($products as $product)
            {
                InvoiceProduct::create([
                    'invoice_id'    =>  $invoice_id,
                    'product_id'    =>  $product['product_id'],
                    'user_id'       =>  $user_id,
                    'qty'           =>  $product['qty'],
                    'sale_price'    =>  $product['sale_price']
                ]);
            }

            DB::commit();
            return 1;
        }
        catch(Exception $exception)
        {
            DB::rollBack();
            return 0;
        }
    }

    function invoiceSelect(Request $request)
    {
        $user_id = $request->header('id');
        $invoice = Invoice::where('user_id', $user_id)->with('customer')->get();
        return $invoice;
    }

    function invoiceDetails(Request $request)
    {
        $user_id            = $request->header('id');
        $customerDetails    = Customer::where('user_id', $user_id)->where('id', $request->input('cus_id'))->first();
        $invoiceToatal      = Invoice::where('user_id', $user_id)->where('id',$request->input('inv_id'))->first();
        $invoiceProduct     = InvoiceProduct::where('invoice_id', $request->input('inv_id'))
            ->where('user_id', $user_id)
            ->with('product')
            ->get();

        $invoice = [
            'customer'  =>  $customerDetails,
            'invoice'   =>  $invoiceToatal,
            'product'   =>  $invoiceProduct
        ];

        return $invoice;
    }

    function invoiceDelete(Request $request)
    {
        DB::beginTransaction();

        try
        {
            $user_id = $request->header('id');
            InvoiceProduct::where('invoice_id', $request->input('inv_id'))->where('user_id', $user_id)->delete();
            Invoice::where('id', $request->input('inv_id'))->delete();
            DB::commit();
            return 1;
        }
        catch(Exception $exception)
        {
            DB::rollBack();
            return 0;
        }
    }


}
