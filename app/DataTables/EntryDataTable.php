<?php

namespace App\DataTables;

use App\Models\Entry;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class EntryDataTable extends DataTable
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
            ->editColumn('supplier.name',function($entry){
                $supplier = $entry->supplier;
                return $supplier ? $supplier->name : '';
                })
                ->editColumn('amount',function($entry){
                    return $entry->amount ?? "";
                })
                ->editColumn('remark',function($entry){
                    return $entry->remark ?? "";
                })
                ->addColumn('proof_document',function($entry){
                    $doc='';
                    $docIcon = view('components.svg-icon', ['icon' => 'add-order'])->render();
                    $doc = !empty($entry->proof_document_url) ? '<a class="p-1 mx-1" href="' . $entry->proof_document_url . '" target="_blank">' . $docIcon . '</a>' : 'No File !';
                    return $doc;
                })
            ->editColumn('entry_date', function ($entry) {
                return $entry->entry_date ?? '';
            })
            ->editColumn('created_at', function ($entry) {
                return $entry->created_at->format('d-m-Y h:i A');
            })
            ->addColumn('action',function($entry){
               $action='';
               if (Gate::check('entry_edit')) {
               $editIcon = view('components.svg-icon', ['icon' => 'edit'])->render();
               $action .= '<button class="btn btn-icon btn-info edit-entry-btn p-1 mx-1" data-href="'.route('entry.edit', $entry->id).'" >'.$editIcon.'</button>';
               }
               if (Gate::check('entry_delete')) {
               $deleteIcon = view('components.svg-icon', ['icon' => 'delete'])->render();
               $action .= '<form action="'.route('entry.destroy', $entry->id).'" method="POST" class="deleteForm m-1">
               <button title="'.trans('quickadmin.qa_delete').'" class="btn btn-icon btn-danger record_delete_btn btn-sm">'.$deleteIcon.'</button>
               </form>';
               }
               return $action;
            })
            ->filterColumn('entry_date', function ($query, $keyword) {
                $query->whereRaw("DATE_FORMAT(entries.entry_date,'%d-%M-%Y') like ?", ["%$keyword%"]); //date_format when searching using date
            })
            ->filterColumn('created_at', function ($query, $keyword) {
                $query->whereRaw("DATE_FORMAT(entries.created_at,'%d-%M-%Y') like ?", ["%$keyword%"]); //date_format when searching using date
            })
            ->rawColumns(['action','proof_document']);
    }

   /**
    * Get the query source of dataTable.
    */
   public function query(Entry $model): QueryBuilder
   {
        return $model->newQuery()->with('supplier');
   }


   public function html(): HtmlBuilder
   {
       return $this->builder()
           ->setTableId('entries-table')
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
           Column::make('supplier.name')->title(trans('quickadmin.entries.fields.supplier_name')),
           Column::make('amount')->title(trans('quickadmin.entries.fields.amount')),
           Column::make('remark')->title(trans('quickadmin.entries.fields.remark')),
           Column::make('proof_document')->title(trans('quickadmin.entries.fields.proof_document'))->orderable(false)->searchable(false),
           Column::make('entry_date')->title(trans('quickadmin.entries.fields.date')),
           Column::make('created_at')->title(trans('quickadmin.entries.fields.created_at')),
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
        return 'Entry_' . date('YmdHis');
    }
}
