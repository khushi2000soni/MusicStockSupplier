
    <div class="row pt-3">
        <div class="col-md-12">
            <div class="form-group">
                <div class="custom-select2 fullselect2">
                    <div class="form-control-inner">
                        <label for="supplier_id">@lang('quickadmin.entries.fields.select_supplier')</label>
                        <select class="get-supplier-select" name="supplier_id" id="supplier_id">
                            @if (!isset($payment_receipt))
                                <option value="" disabled selected>@lang('quickadmin.entries.fields.select_supplier')</option>
                            @endif
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}" {{ isset($payment_receipt) && $payment_receipt->supplier_id == $supplier->id ? 'selected' : '' }}>
                                    {{ $supplier->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label for="email">@lang('quickadmin.entries.fields.amount')<span class="text-danger">*</span></label>
                <div class="input-group">
                    <input type="text" class="form-control" name="amount" value="{{ isset($payment_receipt) ? $payment_receipt->amount : old('amount') }}" id="amount" autocomplete="true" min="0" step=".01" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); if(this.value.includes('-')) this.value = this.value.replace('-', ''); if(this.value.indexOf('.') !== -1) { var parts = this.value.split('.'); this.value = parts[0] + '.' + parts[1].slice(0, 2); }">
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label for="payment_date">@lang('quickadmin.entries.fields.created_at')<span class="text-danger">*</span></label>
                <div class="input-group">
                    <input type="text" class="form-control datetimepicker" value="{{ isset($payment_receipt) ? $payment_receipt->payment_date : old('payment_date') }}" name="payment_date" id="payment_date" autocomplete="true">
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="phone">@lang('quickadmin.entries.fields.remark')</label>
                <div class="input-group">
                    <input type="text" class="form-control" name="remark" value="{{ isset($payment_receipt) ? $payment_receipt->remark : old('remark') }}" id="remark" autocomplete="true">
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label for="payment_receipt_proof">@lang('quickadmin.entries.fields.proof_document')</label>
                @if(isset($payment_receipt) && $payment_receipt->payment_document_url)
                    <a target="_blank" href="{{ $payment_receipt->payment_document_url }}" class="btn btn-info text-danger float-right">
                        <x-svg-icon icon="add-order" /> Preview
                    </a>
                @endif
                <div class="input-group">
                    <input type="file" class="form-control" name="payment_receipt_proof" id="payment_receipt_proof" accept="image/*,.pdf">
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-auto ml-auto mt-4">
            <button type="submit" class="btn btn-primary">@lang('quickadmin.qa_submit')</button>
        </div>
    </div>

