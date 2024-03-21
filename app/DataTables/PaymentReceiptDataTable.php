<?php

namespace App\DataTables;

use App\Models\PaymentReceipt;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class PaymentReceiptDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
           ->addIndexColumn()
           ->editColumn('supplier.name',function($payment_receipt){
            $supplier = $payment_receipt->supplier;
            return $supplier ? $supplier->name : '';
            })
            ->editColumn('amount',function($payment_receipt){
                return $payment_receipt->amount ?? "";
            })
            ->editColumn('remark',function($payment_receipt){
                return $payment_receipt->remark ?? "";
            })
            ->addColumn('payment_receipt_proof',function($payment_receipt){
                $doc='';
                $docIcon = view('components.svg-icon', ['icon' => 'add-order'])->render();
                $doc = !empty($payment_receipt->payment_document_url) ? '<a class="p-1 mx-1" href="' . $payment_receipt->payment_document_url . '" target="_blank">' . $docIcon . '</a>' : 'No File !';
                return $doc;
            })
           ->editColumn('created_at', function ($payment_receipt) {
               return $payment_receipt->created_at->format('d-m-Y h:i A');
           })
           ->addColumn('action',function($payment_receipt){
               $action='';
               if (Gate::check('payment_receipt_edit')) {
               $editIcon = view('components.svg-icon', ['icon' => 'edit'])->render();
               $action .= '<button class="btn btn-icon btn-info edit-payment-receipt-btn p-1 mx-1" data-href="'.route('payment-receipt.edit', $payment_receipt->id).'" >'.$editIcon.'</button>';
               }
               if (Gate::check('payment_receipt_delete')) {
               $deleteIcon = view('components.svg-icon', ['icon' => 'delete'])->render();
               $action .= '<form action="'.route('payment-receipt.destroy', $payment_receipt->id).'" method="POST" class="deleteForm m-1">
               <button title="'.trans('quickadmin.qa_delete').'" class="btn btn-icon btn-danger record_delete_btn btn-sm">'.$deleteIcon.'</button>
               </form>';
               }
               return $action;
           })
           ->filterColumn('created_at', function ($query, $keyword) {
               $query->whereRaw("DATE_FORMAT(payment_receipts.created_at,'%d-%M-%Y') like ?", ["%$keyword%"]); //date_format when searching using date
           })
           ->rawColumns(['action','payment_receipt_proof']);
    }

   /**
    * Get the query source of dataTable.
    */
   public function query(PaymentReceipt $model): QueryBuilder
   {
        return $model->newQuery()->with('supplier');
   }


   public function html(): HtmlBuilder
   {
       return $this->builder()
           ->setTableId('payment_receipts-table')
           ->parameters([
               'responsive' => true,
               'pageLength' => 50,
               'lengthMenu' => [[10, 25, 50, 70, 100, -1], [10, 25, 50, 70, 100, 'All']],
           ])
           ->columns($this->getColumns())
           ->minifiedAjax()
           ->dom('lfrtip')
           ->orderBy(5,'desc')
           ->selectStyleSingle();
   }

   /**
    * Get the dataTable columns definition.
    */
   public function getColumns(): array
   {
       return [
           Column::make('DT_RowIndex')->title(trans('quickadmin.qa_sn'))->orderable(false)->searchable(false),
           Column::make('supplier.name')->title(trans('quickadmin.payment_receipts.fields.supplier_name')),
           Column::make('amount')->title(trans('quickadmin.payment_receipts.fields.amount')),
           Column::make('remark')->title(trans('quickadmin.payment_receipts.fields.remark')),
           Column::make('payment_receipt_proof')->title(trans('quickadmin.payment_receipts.fields.proof_document'))->orderable(false)->searchable(false),
           Column::make('created_at')->title(trans('quickadmin.payment_receipts.fields.created_at')),
           Column::computed('action')
           ->exportable(false)
           ->printable(false)
           ->width(60)
           ->addClass('text-center')->title(trans('quickadmin.qa_action')),
       ];
   }


    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'PaymentReceipt_' . date('YmdHis');
    }
}
