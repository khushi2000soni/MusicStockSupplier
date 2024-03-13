
    <div class="row">
        <div class="col-md-12 mb-2">
            <div class="custom-select2 fullselect2">
                <div class="form-control-inner">
                    <label for="supplier_id">@lang('quickadmin.entries.fields.select_supplier')</label>
                    <select class="get-supplier-select" name="supplier_id" id="supplier_id">
                        <option value="" disabled {{ !isset($entry) ? 'selected' : '' }}>@lang('quickadmin.entries.fields.select_supplier')</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}" {{ isset($lead) && $entry->supplier_id == $supplier->id ? 'selected' : '' }}>
                                {{ $supplier->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label for="email">@lang('quickadmin.entries.fields.amount')<span class="text-danger">*</span></label>
                <div class="input-group">
                    <input type="number" class="form-control" name="amount" value="{{ isset($entry) ? $entry->amount : old('amount') }}" id="amount" autocomplete="true">
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="phone">@lang('quickadmin.entries.fields.remark')</label>
                <div class="input-group">
                    <input type="text" class="form-control" name="remark" value="{{ isset($entry) ? $entry->remark : old('remark') }}" id="remark" autocomplete="true">
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-auto ml-auto mt-4">
            <button type="submit" class="btn btn-primary">@lang('quickadmin.qa_submit')</button>
        </div>
    </div>

