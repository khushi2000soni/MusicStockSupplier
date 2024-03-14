<?php

namespace App\Http\Controllers;

use App\DataTables\EntryDataTable;
use App\Http\Requests\Entry\CreateRequest;
use App\Http\Requests\Entry\UpdateRequest;
use App\Models\Entry;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class EntryController extends Controller
{
    public function index(EntryDataTable $dataTable)
    {
        abort_if(Gate::denies('entry_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return $dataTable->render('admin.entry.index');
    }

    public function printView()
    {
        abort_if(Gate::denies('entry_print'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $entries = Entry::orderBy('id','desc')->get();
        return view('admin.entry.print-entry-list',compact('entries'))->render();
    }

    // public function export(){
    //     abort_if(Gate::denies('entry_export'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    //     $filename = 'Entry-all';
    //     return Excel::download(new EntryExport(), $filename.'.xlsx');
    // }

    public function create()
    {
        $suppliers = Supplier::orderBy('name','asc')->get();
        $htmlView = view('admin.entry.create',compact('suppliers'))->render();
        return response()->json(['success' => true, 'htmlView' => $htmlView]);
    }

    public function store(CreateRequest $request)
    {
        $entry= Entry::create($request->all());
        if($entry && $request->hasFile('proof_document')){
            uploadImage($entry, $request->proof_document, 'entry/entryproof',"entryproof", 'original', 'save', null);
        }

        return response()->json(['success' => true,
        'message' => trans('messages.crud.add_record'),
        'alert-type'=> trans('quickadmin.alert-type.success'),
        'title' => trans('quickadmin.entries.entry'),
        ], 200);
    }

    public function edit(Entry $entry)
    {
        $suppliers = Supplier::orderBy('name','asc')->get();
        $htmlView = view('admin.entry.edit', compact('suppliers','entry'))->render();
        return response()->json(['success' => true, 'htmlView' => $htmlView]);
    }

    public function update(UpdateRequest $request, Entry $entry)
    {
        $entry->update($request->all());
        if($entry && $request->hasFile('proof_document')){
            $actionType = 'save';
            $uploadId = null;
            if($proofDocumentRecord = $entry->proofDocument){
                $uploadId = $proofDocumentRecord->id;
                $actionType = 'update';
            }
            uploadImage($entry, $request->proof_document, 'entry/entryproof',"entryproof", 'original', $actionType, $uploadId);
        }

        return response()->json(['success' => true,
        'message' => trans('messages.crud.update_record'),
        'alert-type'=> trans('quickadmin.alert-type.success')], 200);
    }

    public function destroy(Entry $entry)
    {
        abort_if(Gate::denies('entry_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $entry->delete();
        return response()->json([
            'success' => true,
            'message' => trans('messages.crud.delete_record'),
            'alert-type' => trans('quickadmin.alert-type.success'),
            'title' => trans('quickadmin.entries.entry'),
        ], 200);
    }
}
