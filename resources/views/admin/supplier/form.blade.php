
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="name">@lang('quickadmin.suppliers.fields.name')<span class="text-danger">*</span></label>
                <div class="input-group">
                    <input type="text" class="form-control" name="name" value="{{ isset($supplier) ? $supplier->name : old('name') }}" id="name" autocomplete="true" oninput="this.value = this.value.replace(/[^a-zA-Z0-9\s]/g, '');">
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-auto ml-auto mt-4">
            <button type="submit" class="btn btn-primary">@lang('quickadmin.qa_submit')</button>
        </div>
    </div>

