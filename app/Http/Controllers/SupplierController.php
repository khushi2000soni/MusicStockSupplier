<?php

namespace App\Http\Controllers;

use App\DataTables\SupplierDataTable;
use App\Http\Requests\Supplier\CreateRequest;
use App\Http\Requests\Supplier\UpdateRequest;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
        $query = Supplier::query();
        $suppliers = $query->orderBy('id','desc')->get();
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
        Supplier::create($request->all());
        return response()->json(['success' => true,
        'message' => trans('messages.crud.add_record'),
        'alert-type'=> trans('quickadmin.alert-type.success'),
        'title' => trans('quickadmin.suppliers.supplier'),
        ], 200);
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

}
