@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')
@section('title')@lang('quickadmin.qa_dashboard')@endsection
@section('customCss')
<meta name="csrf-token" content="{{ csrf_token() }}" >
@endsection

@section('main-content')

<section class="section roles" style="z-index: unset">

    <div class="section-body dashboard-card">
        @can('dashboard_widget_access')
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="row diffrent-cards">
                    <div class="col-12 col-md-4 col-lg-3 ">
                        <div class="card card-info five">
                        <div class="card-header">
                            <h4 class="">@lang('quickadmin.dashboard.totalsuppliers')</h4>
                        </div>
                        <div class="card-body">
                            <h4>{{ $totalsuppliers ?? 0 }}</h4>
                        </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-3">
                        <div class="card card-info six" >
                        <div class="card-header">
                            <h4 class="">@lang('quickadmin.dashboard.totalentryamount')</h4>
                        </div>
                        <div class="card-body">
                            <h4>{{ $totalentryamount ?? 0 }}</h4>
                        </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-3">
                        <div class="card card-info seven">
                        <div class="card-header">
                            <h4 class="">@lang('quickadmin.dashboard.totalpaymentreceiptamount')</h4>
                        </div>
                        <div class="card-body">
                            <h4>{{ $totalpaymentreceiptamount ?? 0 }}</h4>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endcan
    </div>
  </section>
@endsection


@section('customJS')
<script src="{{ asset('admintheme/assets/bundles/jquery-ui/jquery-ui.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

</script>


@endsection
