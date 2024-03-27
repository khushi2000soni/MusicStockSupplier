<?php

namespace App\DataTables;

use App\Models\Entry;
use App\Models\PaymentReceipt;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class PaymentHistoryDataTable extends DataTable
{

    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        $query = $query->orderBy('created_at', 'desc');
        return (new EloquentDataTable($query))
        ->addColumn('checkbox', function ($data) {
            $checkbox = "";
            if($data->table_type == "entries"){
                $checkbox = '<input type="checkbox" class="dt_checkbox" name="entryid[]" value="' . $data->id . '">';
            }elseif($data->table_type == "payment_receipts"){
                $checkbox = '<input type="checkbox" class="dt_checkbox" name="payment_receipts[]" value="' . $data->id . '">';
            }
            return $checkbox;
        })
        ->addIndexColumn()
        ->addColumn('created_at', function ($data) {
            return $data->created_at->format('d-m-Y H:i A');
        })
        ->addColumn('particulars',function($data){
            if($data->table_type == "entries"){
                $particulars = "Entry";
            }
            elseif($data->table_type == "payment_receipts"){
                $particulars = "Payment Receipt";
            }
            else{
                $particulars = " ";
            }
            return $particulars;
        })
        ->addColumn('remark',function($data){

            return $data->remark ??""; // If no remark found
        })
        ->addColumn('debit',function($data){
            return $data->table_type == "entries" ? $data->amount : "";
        })
        ->addColumn('credit',function($data){
            return $data->table_type == "payment_receipts" ? $data->amount : "";
        })
        ->rawColumns(['checkbox']);
    }

    public function query(Supplier $supplier): QueryBuilder
    {
        $data = Entry::selectRaw("'entries' AS table_type, entries.*")
        ->where('supplier_id', $this->supplier);
        $data = $data->unionAll(PaymentReceipt::selectRaw("'payment_receipts' AS table_type, payment_receipts.*")
                ->where('supplier_id', $this->supplier));
        return $data->newQuery();
    }

   public function html(): HtmlBuilder
   {
       return $this->builder()
           ->setTableId('suppliers-table')
           ->parameters([
            'responsive' => true,
            //'pageLength' => 50,
            'select' => ['style' => 'multi'], // Enable multi-select
            'selector' => 'td:first-child input[type="checkbox"]',
            //'lengthMenu' => [[10, 25, 50, 70, 100, -1], [10, 25, 50, 70, 100, 'All']],
            'columnDefs' => [ // Optional, for explicit checkboxes definition lfrtip
                [
                    'targets' => 0,
                    'checkboxes' => true,
                ]
            ]
            ])
           ->columns($this->getColumns())
           ->minifiedAjax()
           ->dom('');
           //->orderBy(2,'desc');
   }

   /**
    * Get the dataTable columns definition.
    */
   public function getColumns(): array
   {
       return [
            Column::make('checkbox')->title('<label class="custom-checkbox"><input type="checkbox" id="dt_cb_all" ><span></span></label>')->orderable(false)->searchable(false),
            Column::make('DT_RowIndex')->title(trans('quickadmin.qa_sn'))->orderable(false)->searchable(false)->visible(false),
            Column::make('created_at')->title(trans('quickadmin.suppliers.fields.created_at'))->orderable(false)->searchable(false),
            Column::make('particulars')->title(trans('quickadmin.suppliers.particulars'))->orderable(false)->searchable(false),
            Column::make('remark')->title(trans('quickadmin.suppliers.remark'))->orderable(false)->searchable(false),
            Column::make('debit')->title(trans('quickadmin.suppliers.debit'))->orderable(false)->searchable(false),
            Column::make('credit')->title(trans('quickadmin.suppliers.credit'))->orderable(false)->searchable(false),
       ];
   }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'PaymentHistory_' . date('YmdHis');
    }
}
