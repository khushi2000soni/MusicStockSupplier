<?php

namespace App\Http\Controllers;

use App\DataTables\PaymentHistoryDataTable;
use App\DataTables\SupplierDataTable;
use App\Http\Requests\Supplier\CreateRequest;
use App\Http\Requests\Supplier\UpdateRequest;
use App\Models\Entry;
use App\Models\PaymentReceipt;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;

class SupplierController extends Controller
{
    public function index(SupplierDataTable $dataTable)
    {
        abort_if(Gate::denies('supplier_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return $dataTable->render('admin.supplier.index');
    }

    public function printView()
    {
        abort_if(Gate::denies('supplier_print'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $suppliers = Supplier::orderBy('id','desc')->get();
        return view('admin.supplier.print-supplier-list',compact('suppliers'))->render();
    }

    // public function export(){
    //     abort_if(Gate::denies('supplier_export'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    //     $filename = 'Supplier-all';
    //     return Excel::download(new SupplierExport(), $filename.'.xlsx');
    // }

    public function create()
    {
        $htmlView = view('admin.supplier.create')->render();
        return response()->json(['success' => true, 'htmlView' => $htmlView]);
    }

    public function store(CreateRequest $request)
    {
        $supplier= Supplier::create($request->all());
        return response()->json(['success' => true,
        'message' => trans('messages.crud.add_record'),
        'alert-type'=> trans('quickadmin.alert-type.success'),
        'title' => trans('quickadmin.suppliers.supplier'),
        'supplier' => [
            'id' => $supplier->id,
            'name' => $supplier->name,
        ]
        ], 200);
    }

    public function show(PaymentHistoryDataTable $dataTable, Supplier $supplier)
    {
        abort_if(Gate::denies('supplier_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $totalDebitAmount = $supplier->getTotalDebitAmount();
        $totalCreditAmount = $supplier->getTotalCreditAmount();
        //dd($totalDebitAmount , $totalCreditAmount);
        $closingBalance = $supplier->opening_balance + $totalDebitAmount - $totalCreditAmount;
        return $dataTable->with('supplier', $supplier->id)->render('admin.supplier.show', compact('supplier','totalDebitAmount','totalCreditAmount','closingBalance'));
    }

    public function edit(Supplier $supplier)
    {
        $htmlView = view('admin.supplier.edit', compact('supplier'))->render();
        return response()->json(['success' => true, 'htmlView' => $htmlView]);
    }

    public function update(UpdateRequest $request, Supplier $supplier)
    {
        $supplier->update($request->all());
        return response()->json(['success' => true,
        'message' => trans('messages.crud.update_record'),
        'alert-type'=> trans('quickadmin.alert-type.success')], 200);
    }

    public function destroy(Supplier $supplier)
    {
        abort_if(Gate::denies('supplier_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $supplier->delete();
        return response()->json([
            'success' => true,
            'message' => trans('messages.crud.delete_record'),
            'alert-type' => trans('quickadmin.alert-type.success'),
            'title' => trans('quickadmin.suppliers.supplier'),
        ], 200);
    }

    public function massDestroyPaymentHistory(Request $request)
    {
        abort_if(Gate::denies('supplier_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if($request->ajax()){
            $entryIds = $request->input('entryids');
            $paymentReceiptIds = $request->input('payment_receipt_ids');
            try{
                DB::beginTransaction();
                // Delete entries
                if (!empty($entryIds)) {
                    Entry::whereIn('id', $entryIds)->update(['deleted_by' => auth()->user()->id]);
                    Entry::whereIn('id', $entryIds)->delete();                }
                // Delete payment receipts
                if (!empty($paymentReceiptIds)) {
                    PaymentReceipt::whereIn('id', $paymentReceiptIds)->update(['deleted_by' => auth()->user()->id]);
                    PaymentReceipt::whereIn('id', $paymentReceiptIds)->delete();
                }

                DB::commit();
                return response()->json([
                    'success' => true,
                    'message' => trans('messages.crud.delete_record'),
                    'alert-type' => trans('quickadmin.alert-type.success'),
                    'title' => trans('quickadmin.suppliers.supplier'),
                ], 200);
            }catch(\Exception $e){
                DB::rollBack();
                return response()->json(['success' => false,
                'message' => trans('messages.error1'),
                'alert-type'=> trans('quickadmin.alert-type.error')], 500);
            }
        }

    }
}
