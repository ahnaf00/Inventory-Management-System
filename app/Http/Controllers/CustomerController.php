<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Models\Customer;
use Exception;

class CustomerController extends Controller
{

    function CustomerPage():View
    {
        return view('pages.dashboard.customer-page');
    }

    function CustomerCreate(Request $request)
    {
        $user_id = $request->header('id');
        $customer = Customer::create([
            'name'      =>  $request->input('name'),
            'email'     =>  $request->input('email'),
            'mobile'    =>  $request->input('mobile'),
            'user_id'   =>  $user_id
        ]);

        return $customer;
    }

    function CustomerList(Request $request)
    {
        $user_id = $request->header('id');
        $customer = Customer::where('user_id', $user_id)->get();
        return $customer;
    }


    function CustomerDelete(Request $request)
    {
        $customer_id = $request->input('id');
        $user_id = $request->header('id');

        $customer = Customer::where('id', $customer_id)->where('user_id',$user_id)->delete();
        return $customer;


    }

    function CustomerUpdate(Request $request)
    {
        $customer_id = $request->input('id');
        $user_id = $request->header('id');

        $customer = Customer::where('id', $customer_id)->where('user_id', $user_id)->update([
            'name'=>$request->input('name'),
            'email'=>$request->input('email'),
            'mobile'=>$request->input('mobile')
        ]);
        return $customer;
    }

    function CustomerByID(Request $request)
    {
        $customer_id = $request->input('id');
        $user_id = $request->header('id');

        $customer = Customer::where('id', $customer_id)->where('user_id', $user_id)->first();
        return $customer;
    }
}
