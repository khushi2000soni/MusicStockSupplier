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
    protected $globalVariable;

    public function dataTable($query)
    {
        return datatables()
        ->of($query)
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
        ->addColumn('date', function ($data) {
            //return $data->entry_date ?? "";
            return $data->table_type == "entries" ? $data->entry_date : $data->payment_date;
        })
        // ->addColumn('particulars',function($data){
        //     if($data->table_type == "entries"){
        //         $particulars = "Entry";
        //     }
        //     elseif($data->table_type == "payment_receipts"){
        //         $particulars = "Payment Receipt";
        //     }
        //     else{
        //         $particulars = " ";
        //     }

        //     $routeParams = ['id' => $data->id,'type' => $data->table_type];
        //         $name = '<button class="supplier-type-detail modal_open_btn" data-href="' . route('supplier.type.detail', $routeParams) . '">' . $particulars . '</button>';
        //     return $name;
        // })
        ->addColumn('particulars', function($data) {

            if ($data->table_type == "entries") {
                $particulars = "Entry";
                $proofdoc = !empty($data->proof_document_url) ? $data->proof_document_url : null;
            } else{
                $particulars = "Payment Receipt";
                $proofdoc = !empty($data->payment_document_url) ? $data->payment_document_url : null;
            }

            $name = !is_null($proofdoc) ? '<a class="open_new_tab_doc" href="' . $proofdoc . '" target="_blank">' .$particulars. '</a>' : $particulars;
            return $name;
        })
        ->addColumn('created_at', function ($data) {
            return $data->created_at->format('d-m-Y H:i A');
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
        ->addColumn('balance',function($data){

            $globalValue = $this->globalVariable;
            if($data->table_type == "entries"){
                $globalValue += $data->amount??0;
            }else{
                $globalValue -= $data->amount??0;
            }

            if (is_numeric($globalValue)) {
                // Format the numeric value with two decimal places, even if the value after the decimal point is zero
                $globalValue = number_format($globalValue, 2, '.', '');
            }

            $this->globalVariable = $globalValue;
            return $globalValue;
        })
        ->rawColumns(['checkbox','particulars']);
    }

    public function query(Supplier $supplier)
    {
        // $data = Entry::selectRaw("'entries' AS table_type, entries.*")
        // ->where('supplier_id', $this->supplier);
        // $data = $data->unionAll(PaymentReceipt::selectRaw("'payment_receipts' AS table_type, payment_receipts.*")
        //         ->where('supplier_id', $this->supplier));
        // return $data->newQuery();
        $entriesData = Entry::selectRaw("'entries' AS table_type,entries.entry_date AS transaction_date, entries.*")->where('supplier_id', $this->supplier);
        $paymentReceiptsData = PaymentReceipt::selectRaw("'payment_receipts' AS table_type,payment_receipts.payment_date As transaction_date, payment_receipts.*")->where('supplier_id', $this->supplier);
        $data = collect($entriesData->get())->merge($paymentReceiptsData->get());
        $data= $data->sortBy('transaction_date');
        return  $data;
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('suppliers-table')
            ->parameters([
                'responsive' => true,
                'pageLength' => 50,
                'lengthMenu' => [[10, 25, 50, 70, 100, -1], [10, 25, 50, 70, 100, 'All']],
                ])
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('');
    }

    /**
        * Get the dataTable columns definition.
        */
    public function getColumns(): array
    {
        return [
                Column::computed('checkbox')->title('<label class="custom-checkbox"><input type="checkbox" id="dt_cb_all" ><span></span></label>')->titleAttr('')->orderable(false)->searchable(false),
                Column::make('DT_RowIndex')->title(trans('quickadmin.qa_sn'))->orderable(false)->searchable(false)->visible(false),
                Column::make('date')->title(trans('quickadmin.suppliers.fields.date'))->orderable(false)->searchable(false),
                Column::make('particulars')->title(trans('quickadmin.suppliers.particulars'))->orderable(false)->searchable(false),
                Column::make('created_at')->title(trans('quickadmin.suppliers.fields.created_at'))->orderable(false)->searchable(false),
                Column::make('remark')->title(trans('quickadmin.suppliers.remark'))->orderable(false)->searchable(false),
                Column::make('debit')->title(trans('quickadmin.suppliers.debit'))->orderable(false)->searchable(false),
                Column::make('credit')->title(trans('quickadmin.suppliers.credit'))->orderable(false)->searchable(false),
                Column::make('balance')->title(trans('quickadmin.suppliers.balance'))->orderable(false)->searchable(false)->addClass('text-center'),
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
