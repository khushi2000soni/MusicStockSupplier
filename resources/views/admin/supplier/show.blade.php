
@extends('layouts.app')
@section('title')@lang('quickadmin.suppliers.payment_history')@endsection
@section('customCss')
<meta name="csrf-token" content="{{ csrf_token() }}" >
<link rel="stylesheet" href="{{ asset('admintheme/assets/css/printView-datatable.css')}}">

<style>
    /* @media print {
        table, table tr, table td {
            border: 1px solid #3d3c3c;
        }
    } */
    .custom-select2 select{
        width: 200px;
        z-index: 1;
        position: relative;
    }
    .custom-select2 .form-control-inner{
        position: relative;
    }
    .custom-select2 .form-control-inner label{
        position: absolute;
        left: 10px;
        top: -8px;
        background-color: #fff;
        padding: 0 5px;
        z-index: 1;
        font-size: 12px;
    }
    .select2-results{
        padding-top: 48px;
        position: relative;
    }
    .select2-link2{
        position: absolute;
        top: 6px;
        left: 5px;
        width: 100%;
    }
    .select2-container--default .select2-selection--single,
    .select2-container--default .select2-selection--single .select2-selection__arrow{
        height: 40px;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered{
        line-height: 41px;
    }
    .select2-search--dropdown .select2-search__field{
        padding: 10px;
        font-size: 15px;
    }
    .select2-search--dropdown .select2-search__field:focus{
        outline: none;
    }
    .select2-link2 .btns {
        color: #3584a5;
        background-color: transparent;
        border: none;
        font-size: 14px;
        padding: 7px 15px;
        cursor: pointer;
        border: 1px solid #3584a5;
        border-radius: 60px;
    }
    #centerModal, #editModal{
        z-index: 99999;
    }
    #centerModal::before, #editModal::before{
        display: none;
    }

    .modal-open .modal-backdrop.show{
        display: block !important;
        z-index: 9999;
    }

    .select2-dropdown{
        z-index: 99999;
    }
    .cart_filter_box{
        border-bottom: 1px solid #e5e9f2;
    }
    #editModal .select2-results{
        padding-top: 0px !important;
    }
    .supplier-table1 thead th:first-child{
        width: 20px !important;
        min-width: 20px !important;
        max-width: 20px !important;
    }
    .supplier-table1 thead th:last-child{
        min-width: 10rem !important;
        width: 10rem !important;
        max-width: 10rem !important;
    }
    .supplier-table1 thead th:nth-last-of-type(2),
    .supplier-table1 thead th:nth-last-of-type(3){
        min-width: 12rem !important;
        width: 12rem !important;
        max-width: 12rem !important;
    }
    .openingbalancetable tbody td{
        padding-left: .75rem !important;
        padding-right: .75rem !important;
    }
    .openingbalancetable tbody td:last-child{
        min-width: calc(10rem + 1.55rem) !important;
        width: calc(10rem + 1.55rem) !important;
        max-width: calc(10rem + 1.55rem) !important;
    }
    .openingbalancetable tbody td:nth-last-of-type(2),
    .openingbalancetable tbody td:nth-last-of-type(3){
        min-width: calc(12rem + 1.5rem) !important;
        width: calc(12rem + 1.5rem) !important;
        max-width: calc(12rem + 1.5rem) !important;
    }
</style>
@endsection
@section('main-content')

<section class="section roles" style="z-index: unset">
    <div class="section-body">
          <div class="row">
            <div class="col-12">
              <div class="card pt-2">
                <div class="card-body">
                    <div class="row align-items-center mb-4 cart_filter_box pb-3">
                        <div class="col">
                            <h4>{{ $supplier->name ?? ""}}</h4>
                        </div>
                        <div class="col-md-auto col-12 mt-md-0 mt-3">
                            <div class="row align-items-center">
                                <div class="col-auto px-md-1 pr-1">
                                    @can('supplier_delete')
                                    <button type="button" class="addnew-btn sm_btn circlebtn" id="deleteSelectedPaymentHistory" data-href="" title="@lang('quickadmin.qa_delete')"><x-svg-icon icon="delete" /></button>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive fixed_Search supplier-table1">
                        {{$dataTable->table(['class' => 'table dt-responsive supplierTable', 'style' => 'width:100%;','id'=>'dataaTable'])}}
                        <table class="table openingbalancetable">
                            <tbody>
                            <!-- Current Balance Row -->
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="textright font-weight-bold">@lang('quickadmin.suppliers.fields.current_balance')</td>
                                <td>{{$supplier->total_debit_amount ?? 0}}</td>
                                <td class="text-center">{{$supplier->total_credit_amount ?? 0}}</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="textright font-weight-bold">@lang('quickadmin.suppliers.fields.closing_balance')</td>
                                <td>{{$supplier->closing_balance ?? 0}}</td>
                                <td class="text-center"></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>
  </section>

@endsection


@section('customJS')
{!! $dataTable->scripts() !!}
<script src="{{ asset('admintheme/assets/bundles/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('admintheme/assets/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
  <!-- Page Specific JS File -->
<script src="{{ asset('admintheme/assets/js/page/datatables.js') }}"></script>

<script>
$(document).ready(function () {
    var DataaTable = $('#dataaTable').DataTable();

    $(document).on('click', '#deleteSelectedPaymentHistory', function(e) {
        e.preventDefault();
        var entry_selectedIds = [];
        var payment_receipt_selectedIds = [];
        $('input[name="entryid[]"]:checked').each(function() {
        entry_selectedIds.push($(this).val());
        });

        $('input[name="payment_receipts[]"]:checked').each(function() {
            payment_receipt_selectedIds.push($(this).val());
        });

        console.log(entry_selectedIds, payment_receipt_selectedIds);

        if(entry_selectedIds.length == 0 && payment_receipt_selectedIds.length == 0) {
            swal("{{ trans('quickadmin.suppliers.payment_history') }}", 'Please Select Record', 'error');
            return false;
        }

        swal({
        title: "{{ trans('messages.deletetitle') }}",
        text: "{{ trans('messages.areYouSure') }}",
        icon: 'warning',
        buttons: {
        confirm: 'Yes, delete it',
        cancel: 'No, cancel',
        },
        dangerMode: true,
        }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
            url: "{{ route('payment-history.massDestroy')}}",
            type: 'DELETE',
            data: {
            entryids: entry_selectedIds,
            payment_receipt_ids: payment_receipt_selectedIds,
            },
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if(response.success) {
                    var alertType = response['alert-type'];
                    var message = response['message'];
                    var title = "{{ trans('quickadmin.suppliers.payment_history') }}";
                    showToaster(title,alertType,message);
                    DataaTable.ajax.reload();
                }
                else {
                    swal("{{ trans('quickadmin.suppliers.payment_history') }}", 'Some Mistake is there.', 'error');
                }
            },
            error: function (xhr) {
                // Handle error response
                // swal("{{ trans('quickadmin.suppliers.payment_history') }}", 'Some Mistake is there.', 'error');
            }
            });
        }
        });
    });

    $('#dt_cb_all').click(function() {
        // If the "select all" checkbox is checked
        if ($(this).prop('checked')) {
            // Check all checkboxes in the table rows
            $('.dt_checkbox').prop('checked', true);
        } else {
            // Uncheck all checkboxes in the table rows
            $('.dt_checkbox').prop('checked', false);
        }
    });
});
</script>


@endsection
