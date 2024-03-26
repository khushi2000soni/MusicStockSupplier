@extends('layouts.print-view.print-layout')
@section('title')@lang('quickadmin.supplier-management.fields.list')@endsection

@section('custom_css')

@endsection

@section('content')
    <div class="page-header">
        <header style="padding: 1px 0;">
            <h2 style="margin: 0;color: #2a2a33;font-size: 20px;font-weight: bold; text-align:center;"><strong>@lang('quickadmin.supplier-management.fields.list')</strong></h2>
        </header>
    </div>
    {{-- <footer>
        <div class="pagenum-container"><small>Page <span class="pagenum"></span></small></div>
    </footer> --}}
    <main class="main" style="width:100%; max-width: 100%;margin: 0 auto;padding: 40px 0;padding-top: 20px;">
        <table cellpadding="0" cellspacing="0" width="100%" style="color: #000;font-size: 16px;">
            <thead>
                <tr>
                    <th style="padding: 10px;border: 1px solid #000;border-right: none;" align="left">@lang('quickadmin.qa_sn')</th>
                    <th style="padding: 10px;border: 1px solid #000;border-right: none;" align="center">@lang('quickadmin.suppliers.fields.name')</th>
                    <th style="padding: 10px;border: 1px solid #000;" align="center">@lang('quickadmin.suppliers.fields.created_at')
                </tr>
            </thead>
            <tbody>

                @forelse ($suppliers as $key => $supplier)
                <tr>
                    <td style="padding: 10px;border: 1px solid #000;border-right: none;border-top: none;" align="left">{{ $key + 1 }}</td>
                    <td style="padding: 10px;border: 1px solid #000;border-right: none;border-top: none;" align="center">{{ $supplier->name ?? '' }}</td>
                    <td style="padding: 10px;border: 1px solid #000;border-top: none;" align="center">{{ $supplier->created_at ? $supplier->created_at->format('d-m-Y h:i:A') : '' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4">No Record Found!</td>
                </tr>
                @endforelse
            </tbody>

        </table>

    </main>

@endsection
