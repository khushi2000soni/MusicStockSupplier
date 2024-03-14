<?php

namespace App\Http\Controllers;

use App\DataTables\PaymentReceiptDataTable;
use App\Http\Requests\PaymentReceipt\CreateRequest;
use App\Http\Requests\PaymentReceipt\UpdateRequest;
use App\Models\PaymentReceipt;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class PaymentReceiptController extends Controller
{
    public function index(PaymentReceiptDataTable $dataTable)
    {
        abort_if(Gate::denies('payment_receipt_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return $dataTable->render('admin.payment-receipt.index');
    }

    public function printView()
    {
        abort_if(Gate::denies('payment_receipt_print'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $payment_receipts = PaymentReceipt::orderBy('id','desc')->get();
        return view('admin.payment-receipt.print-payment-receipt-list',compact('payment_receipts'))->render();
    }

    // public function export(){
    //     abort_if(Gate::denies('payment_receipt_export'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    //     $filename = 'PaymentReceipt-all';
    //     return Excel::download(new PaymentReceiptExport(), $filename.'.xlsx');
    // }

    public function create()
    {
        $suppliers = Supplier::orderBy('name','asc')->get();
        $htmlView = view('admin.payment-receipt.create',compact('suppliers'))->render();
        return response()->json(['success' => true, 'htmlView' => $htmlView]);
    }

    public function store(CreateRequest $request)
    {
        $payment_receipt= PaymentReceipt::create($request->all());
        if($payment_receipt && $request->hasFile('payment_receipt_proof')){
            uploadImage($payment_receipt, $request->payment_receipt_proof, 'payment-receipt/paymentproof',"payment_receipt_proof", 'original', 'save', null);
        }

        return response()->json(['success' => true,
        'message' => trans('messages.crud.add_record'),
        'alert-type'=> trans('quickadmin.alert-type.success'),
        'title' => trans('quickadmin.payment_receipts.payment_receipt'),
        ], 200);
    }

    public function edit(PaymentReceipt $payment_receipt)
    {
        $suppliers = Supplier::orderBy('name','asc')->get();
        $htmlView = view('admin.payment-receipt.edit', compact('suppliers','payment_receipt'))->render();
        return response()->json(['success' => true, 'htmlView' => $htmlView]);
    }

    public function update(UpdateRequest $request, PaymentReceipt $payment_receipt)
    {
        $payment_receipt->update($request->all());
        if($payment_receipt && $request->hasFile('payment_receipt_proof')){
            $actionType = 'save';
            $uploadId = null;
            if($paymentDocumentRecord = $payment_receipt->paymentDocument){
                $uploadId = $paymentDocumentRecord->id;
                $actionType = 'update';
            }
            uploadImage($payment_receipt, $request->payment_receipt_proof, 'payment-receipt/paymentproof',"payment_receipt_proof", 'original', $actionType, $uploadId);
        }

        return response()->json(['success' => true,
        'message' => trans('messages.crud.update_record'),
        'alert-type'=> trans('quickadmin.alert-type.success')], 200);
    }

    public function destroy(PaymentReceipt $payment_receipt)
    {
        abort_if(Gate::denies('payment_receipt_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $payment_receipt->delete();
        return response()->json([
            'success' => true,
            'message' => trans('messages.crud.delete_record'),
            'alert-type' => trans('quickadmin.alert-type.success'),
            'title' => trans('quickadmin.payment_receipts.payment_receipt'),
        ], 200);
    }
}
