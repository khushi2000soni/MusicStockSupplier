<div class="modal fade px-3" id="supplierTypeDetailMaodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="col-md-8">
                    <h6>@lang('quickadmin.entries.fields.supplier_name') : {{ $data->supplier? $data->supplier->name : "" }} </h4>
                    <h6>@lang('quickadmin.suppliers.particulars') : {{ $type == "payment_receipts" ? 'Payment Receipt' : 'Entry'}}</h4>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <div class="card">
                    <div class="card-body p-0">
                        <table id="CatPRoductdataTable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>@lang('quickadmin.suppliers.fields.date')</th>
                                    <th>@lang('quickadmin.entries.fields.amount')</th>
                                    <th>@lang('quickadmin.entries.fields.remark')</th>
                                    <th>@lang('quickadmin.entries.fields.proof_document')</th>
                                    <th>@lang('quickadmin.entries.fields.created_at')</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $type == "payment_receipts" ? $data->payment_date : $data->entry_date }}</td>
                                    <td>{{ $data->amount ?? '0' }}</td>
                                    <td>{{ $data->remark ?? '0' }}</td>
                                    <td>
                                        @php
                                            $docIcon = view('components.svg-icon', ['icon' => 'add-order'])->render();
                                            if ($type == "entries") {
                                                $proofdoc = !empty($data->proof_document_url) ? $data->proof_document_url : null;

                                            } else {
                                                $proofdoc = !empty($data->payment_document_url) ? $data->payment_document_url : null;

                                            }
                                            echo !is_null($proofdoc) ? '<a class="p-1 mx-1" href="' . $proofdoc . '" target="_blank">' . $docIcon . '</a>' : 'No File !';
                                        @endphp
                                    </td>
                                    <td>{{ $data->created_at->format('d-m-Y h:i A') ?? "" }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


