@extends('layouts.print-view.print-layout')
@section('title')@lang('quickadmin.entry-management.fields.list')@endsection

@section('custom_css')

@endsection

@section('content')
    <div class="page-header">
        <header style="padding: 1px 0;">
            <h2 style="margin: 0;color: #2a2a33;font-size: 20px;font-weight: bold; text-align:center;"><strong>@lang('quickadmin.entry-management.fields.list')</strong></h2>
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
                    <th style="padding: 10px;border: 1px solid #000;border-right: none;" align="center">@lang('quickadmin.entries.fields.supplier_name')</th>
                    <th style="padding: 10px;border: 1px solid #000;border-right: none;" align="center">@lang('quickadmin.entries.fields.amount')</th>
                    <th style="padding: 10px;border: 1px solid #000;" align="center">@lang('quickadmin.entries.fields.remark')
                </tr>
            </thead>
            <tbody>

                @forelse ($entries as $key => $entry)
                <tr>
                    <td style="padding: 10px;border: 1px solid #000;border-right: none;border-top: none;" align="left">{{ $key + 1 }}</td>
                    <td style="padding: 10px;border: 1px solid #000;border-right: none;border-top: none;" align="center">{{ $entry->supplier_id ? $entry->supplier->name : '' }}</td>
                    <td style="padding: 10px;border: 1px solid #000;border-right: none;border-top: none;" align="center">{{ $entry->amount ?? '' }}</td>
                    <td style="padding: 10px;border: 1px solid #000;border-top: none;" align="center">{{ $entry->remark ?? '' }}</td>
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