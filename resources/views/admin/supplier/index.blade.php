
@extends('layouts.app')
@section('title')@lang('quickadmin.supplier-management.fields.list')@endsection
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
                            <h4>@lang('quickadmin.supplier-management.fields.list')</h4>
                        </div>

                        <div class="col-md-auto col-12 mt-md-0 mt-3">
                            <div class="row align-items-center">
                                <div class="col-auto px-md-1 pr-1">
                                    @can('supplier_create')
                                    <button type="button" class="addnew-btn addRecordBtn sm_btn circlebtn"  data-href="{{ route('supplier.create')}}" title="@lang('quickadmin.qa_add_new')"><x-svg-icon icon="add" /></button>
                                    @endcan
                                </div>
                                <div class="col-auto px-1">
                                    @can('supplier_print')
                                    <a href="{{ route('supplier.print') }}" class="btn printbtn h-10 col circlebtn"  id="print-button" title="@lang('quickadmin.qa_print')"> <x-svg-icon icon="print" /></a>
                                    @endcan
                                </div>
                                {{-- <div class="col-auto pl-1">
                                    @can('supplier_export')
                                    <a href="{{ route('supplier.export') }}" class="btn excelbtn h-10 col circlebtn"  id="excel-button" title="@lang('quickadmin.qa_excel')"><x-svg-icon icon="excel" /></a>
                                    @endcan
                                </div> --}}
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive fixed_Search">
                        {{$dataTable->table(['class' => 'table dt-responsive supplierTable', 'style' => 'width:100%;','id'=>'dataaTable'])}}
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>
  </section>
  <div class="popup_render_div"></div>
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

    $('#print-button').printPage();

    // Page show from top when page changes
    $(document).on('draw.dt','#dataaTable', function (e) {
        e.preventDefault();
        $('html, body').animate({
            scrollTop: 0
        }, 'fast');
    });

    $(document).on('click' , 'excel-button' , function(e){
        e.preventDefault();
        var iframe = document.createElement('iframe');
        iframe.style.display = 'none';
        iframe.src = '/supplier-export'; // Replace with the actual URL for your export route
        document.body.appendChild(iframe);
    });

    $(document).on('click', '.addRecordBtn', function (e) {
        e.preventDefault();
        var hrefUrl = $(this).attr('data-href');
        $.ajax({
            type: 'get',
            url: hrefUrl,
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    $('.popup_render_div').html(response.htmlView);
                    $('.popup_render_div #centerModal').modal('show');
                }
            }
        });
    });


    $("body").on("click", ".edit-supplier-btn", function () {
        var hrefUrl = $(this).attr('data-href');
        $.ajax({
            type: 'get',
            url: hrefUrl,
            dataType: 'json',
            success: function (response) {
                if(response.success) {
                    $('.popup_render_div').html(response.htmlView);
                    $('#editModal').modal('show');
                }
            }
        });
    });

    /// Add Supplier
    $(document).on('submit', '#centerModal #AddForm', function (e) {
        e.preventDefault();

        $("#centerModal #AddForm button[type=submit]").prop('disabled',true);
        $(".error").remove();
        $(".is-invalid").removeClass('is-invalid');
        var formData = $(this).serialize();
        var formAction = $(this).attr('action');
        $.ajax({
            url: formAction,
            type: 'POST',
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: formData,
            success: function (response) {
                    $('#centerModal').modal('hide');
                    var alertType = response['alert-type'];
                    var message = response['message'];
                    var title = "{{ trans('quickadmin.suppliers.supplier') }}";
                    showToaster(title,alertType,message);
                    $('#centerModal #AddForm')[0].reset();
                   // location.reload();
                   DataaTable.ajax.reload();
                   $("#centerModal #AddForm button[type=submit]").prop('disabled',false);
            },
            error: function (xhr) {
                var errors= xhr.responseJSON.errors;
                console.log(xhr.responseJSON);

                for (const elementId in errors) {
                    $("#centerModal #"+elementId).addClass('is-invalid');
                    var errorHtml = '<div><span class="error text-danger">'+errors[elementId]+'</span></';
                    $(errorHtml).insertAfter($("#centerModal #"+elementId).parent());
                }
                $("#centerModal #AddForm button[type=submit]").prop('disabled',false);
            }
        });
    });


    $(document).on('submit', '#EditForm', function (e) {
        e.preventDefault();
        $("#EditForm button[type=submit]").prop('disabled',true);
        $(".error").remove();
        $(".is-invalid").removeClass('is-invalid');
        var formData = $(this).serialize();
        var formAction = $(this).attr('action');
        $.ajax({
            url: formAction,
            type: 'PUT',
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
            data: formData,
            success: function (response) {
                    $('#editModal').modal('hide');
                    var alertType = response['alert-type'];
                    var message = response['message'];
                    var title = "{{ trans('quickadmin.suppliers.supplier') }}";
                    showToaster(title,alertType,message);
                    $('#EditForm')[0].reset();
                    //location.reload();
                    DataaTable.ajax.reload();
                    $("#EditForm button[type=submit]").prop('disabled',false);
            },
            error: function (xhr) {
                var errors= xhr.responseJSON.errors;
                console.log(xhr.responseJSON);

                for (const elementId in errors) {
                    $("#EditForm #"+elementId).addClass('is-invalid');
                    var errorHtml = '<div><span class="error text-danger">'+errors[elementId]+'</span></';
                    $(errorHtml).insertAfter($("#EditForm #"+elementId).parent());
                }
                $("#EditForm button[type=submit]").prop('disabled',false);
            }
        });
    });


    $(document).on('submit', '.deleteForm', function(e) {
        e.preventDefault();
        var formAction = $(this).attr('action');
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
            url: formAction,
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                var alertType = response['alert-type'];
                    var message = response['message'];
                    var title = "{{ trans('quickadmin.suppliers.supplier') }}";
                    showToaster(title,alertType,message);
                    DataaTable.ajax.reload();
                    // location.reload();

            },
            error: function (xhr) {
                // Handle error response
                swal("{{ trans('quickadmin.suppliers.supplier') }}", 'some mistake is there.', 'error');
            }
            });
        }
        });
    });

});



</script>
@endsection