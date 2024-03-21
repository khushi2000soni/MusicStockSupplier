
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="name">@lang('quickadmin.suppliers.fields.name')<span class="text-danger">*</span></label>
                <div class="input-group">
                    <input type="text" class="form-control" name="name" value="{{ isset($supplier) ? $supplier->name : old('name') }}" id="name" autocomplete="true" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '');">
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="opening_balance">@lang('quickadmin.suppliers.fields.opening_balance')</label>
                <div class="input-group">
                    <input type="text" class="form-control" name="opening_balance" value="{{ isset($supplier) ? $supplier->opening_balance : '0' }}" id="opening_balance" min="0" step=".01" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); if(this.value.includes('-')) this.value = this.value.replace('-', ''); if(this.value.indexOf('.') !== -1) { var parts = this.value.split('.'); this.value = parts[0] + '.' + parts[1].slice(0, 2); }">
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-auto ml-auto mt-4">
            <button type="submit" class="btn btn-primary">@lang('quickadmin.qa_submit')</button>
        </div>
    </div>

