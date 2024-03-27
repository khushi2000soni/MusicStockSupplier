<?php

namespace App\DataTables;

use App\Models\Supplier;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class SupplierDataTable extends DataTable
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
        ->editColumn('name',function($supplier){
            return $supplier->name ?? "";
        })
        ->addColumn('closing_balance', function ($supplier) {
            return $supplier->closing_balance ?? 0;
        })
        ->editColumn('created_at', function ($supplier) {
            return $supplier->created_at->format('d-m-Y h:i:s A');
        })
        ->addColumn('action',function($supplier){
            $action='';
            if (Gate::check('supplier_show')) {
                $editIcon = view('components.svg-icon', ['icon' => 'view'])->render();
                $action .= '<a class="btn btn-icon btn-info p-1 mx-1" href="'.route('supplier.show', $supplier->id).'">'.$editIcon.'</a>';
                }
            if (Gate::check('supplier_edit')) {
                $editIcon = view('components.svg-icon', ['icon' => 'edit'])->render();
                $action .= '<button class="btn btn-icon btn-info edit-supplier-btn p-1 mx-1" data-href="'.route('supplier.edit', $supplier->id).'">'.$editIcon.'</button>';
            }
            // if (Gate::check('supplier_delete')) {
            //     $deleteIcon = view('components.svg-icon', ['icon' => 'delete'])->render();
            //     $action .= '<form action="'.route('supplier.destroy', $supplier->id).'" method="POST" class="deleteForm m-1">
            //     <button title="'.trans('quickadmin.qa_delete').'" class="btn btn-icon btn-danger record_delete_btn btn-sm">'.$deleteIcon.'</button>
            //     </form>';
            // }
            return $action;
        })

        ->filterColumn('created_at', function ($query, $keyword) {
            $query->whereRaw("DATE_FORMAT(suppliers.created_at,'%d-%M-%Y') like ?", ["%$keyword%"]); //date_format when searching using date
        })
        ->rawColumns(['action']);
    }

   /**
    * Get the query source of dataTable.
    */
   public function query(Supplier $model): QueryBuilder
   {
       return $model->newQuery();
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
           ->dom('lfrtip')
           ->orderBy(1,'asc');
        //    ->selectStyleSingle();
   }

   /**
    * Get the dataTable columns definition.
    */
   public function getColumns(): array
   {
       return [
           Column::make('DT_RowIndex')->title(trans('quickadmin.qa_sn'))->orderable(false)->searchable(false),
           Column::make('name')->title(trans('quickadmin.suppliers.fields.name')),
           Column::make('closing_balance')->title(trans('quickadmin.suppliers.fields.closing_balance')),
           Column::make('created_at')->title(trans('quickadmin.suppliers.fields.created_at')),
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
        return 'Supplier_' . date('YmdHis');
    }
}
