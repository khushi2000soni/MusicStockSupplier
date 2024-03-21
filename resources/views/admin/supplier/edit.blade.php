<div class="modal fade px-3" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalCenterTitle">@lang('quickadmin.suppliers.fields.edit')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="EditForm" action="{{route('supplier.update',$supplier->id)}}">
                @include('admin.supplier.form')
                </form>
                {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
            </div>
        </div>
    </div>
</div>
