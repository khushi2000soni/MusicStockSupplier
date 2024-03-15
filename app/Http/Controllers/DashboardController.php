<?php

namespace App\Http\Controllers;

use App\Models\Entry;
use App\Models\PaymentReceipt;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $totalsuppliers = Supplier::count();
        $totalentryamount = Entry::sum('amount');
        $totalpaymentreceiptamount = PaymentReceipt::sum('amount');
        //dd($totalsuppliers,$totalentryamount, $totalpaymentreceiptamount);
        return view('admin.dashboard',compact('totalsuppliers','totalentryamount','totalpaymentreceiptamount'));
    }

}
