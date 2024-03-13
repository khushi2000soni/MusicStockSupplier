
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="name">@lang('quickadmin.suppliers.fields.name')<span class="text-danger">*</span></label>
                <div class="input-group">
                    <input type="text" class="form-control" name="name" value="{{ isset($supplier) ? $supplier->name : old('name') }}" id="name" autocomplete="true">
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="email">@lang('quickadmin.suppliers.fields.email')<span class="text-danger">*</span></label>
                <div class="input-group">
                    <input type="email" class="form-control" name="email" value="{{ isset($supplier) ? $supplier->email : old('email') }}" id="email" autocomplete="true">
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="phone">@lang('quickadmin.suppliers.fields.ph_num')</label>
                <div class="input-group">
                    <input type="text" class="form-control" name="phone" value="{{ isset($supplier) ? $supplier->phone : old('phone') }}" id="phone" autocomplete="true">
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="opening_balance">@lang('quickadmin.suppliers.fields.opening_balance')</label>
                <div class="input-group">
                    <input type="number" class="form-control" name="opening_balance" value="{{ isset($supplier) ? $supplier->opening_balance : old('opening_balance') }}" id="opening_balance" min="0" step=".01" onkeydown="javascript: return ['Tab','NumpadDecimal','Period', 'Backspace','Delete','ArrowLeft','ArrowRight'].includes(event.code) ? true : !isNaN(Number(event.key)) && event.code!=='Space'">
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-auto ml-auto mt-4">
            <button type="submit" class="btn btn-primary">@lang('quickadmin.qa_submit')</button>
        </div>
    </div>

