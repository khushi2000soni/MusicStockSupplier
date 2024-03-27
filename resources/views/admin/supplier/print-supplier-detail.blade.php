@extends('layouts.print-view.print-layout')
@section('title')@lang('quickadmin.supplier-management.fields.detail')@endsection

@section('custom_css')

@endsection

@section('content')
    <div class="page-header">
        <header style="padding: 1px 0;">
            <h2 style="margin: 0;color: #2a2a33;font-size: 20px;font-weight: bold; text-align:center;"><strong>@lang('quickadmin.supplier-management.fields.detail')</strong></h2>
        </header>
    </div>
    {{-- <footer>
        <div class="pagenum-container"><small>Page <span class="pagenum"></span></small></div>
    </footer> --}}
    <main class="main" style="width:100%; max-width: 100%;margin: 0 auto;padding: 40px 0;padding-top: 20px;">
        <table cellpadding="0" cellspacing="0" width="100%" style="color: #000;font-size: 16px;">
            <tbody>
                <tr>
                    <td colspan="4" style="padding-bottom: 20px"><div class="" style="color: #2a2a33;font-size: 16px; text-align:left;">@lang('quickadmin.suppliers.fields.name') : {{ $supplier->name }}</div></td>
                </tr>
                <tr>
                    <th style="padding: 10px;border: 1px solid #000;border-right: none;" align="left">@lang('quickadmin.qa_sn')</th>
                    <th style="padding: 10px;border: 1px solid #000;border-right: none;" align="center">@lang('quickadmin.suppliers.fields.date')</th>
                    <th style="padding: 10px;border: 1px solid #000;border-right: none;" align="center">@lang('quickadmin.suppliers.particulars')</th>
                    <th style="padding: 10px;border: 1px solid #000;border-right: none;" align="center">@lang('quickadmin.suppliers.debit')</th>
                    <th style="padding: 10px;border: 1px solid #000;" align="center">@lang('quickadmin.suppliers.credit')</th>

                </tr>
                @forelse ($alldata as $key => $data)
                <tr>
                    <td style="padding: 10px;border: 1px solid #000;border-right: none;border-top: none;" align="left">{{ $key + 1 }}</td>
                    <td style="padding: 10px;border: 1px solid #000;border-right: none;border-top: none;" align="center">{{ $data->entry_date ??  '' }}</td>
                    <td style="padding: 10px;border: 1px solid #000;border-right: none;border-top: none;" align="center">{{ $data->table_type == "entries" ? "Entry" : "Payment Receipt" }}</td>
                    <td style="padding: 10px;border: 1px solid #000;border-right: none;border-top: none;" align="center">{{ $data->table_type == "entries" ? $data->amount : "" }}</td>
                    <td style="padding: 10px;border: 1px solid #000;border-top: none;" align="center">{{ $data->table_type == "payment_receipts" ? $data->amount : "" }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4">No Record Found!</td>
                </tr>
                @endforelse
                <tr>
                    <th colspan="3" style="padding: 10px;border: 1px solid #000;border-right: none;border-top: none;" align="right">@lang('quickadmin.suppliers.fields.current_balance')</th>
                    <th style="padding: 10px;border: 1px solid #000;border-top: none;border-right: none;" align="center">{{ $supplier->total_debit_amount }}</th>
                    <th style="padding: 10px;border: 1px solid #000;border-top: none;" align="center">{{ $supplier->total_credit_amount }}</th>
                </tr>
                <tr>
                    <th colspan="3" style="padding: 10px;border: 1px solid #000;border-right: none;border-top: none;" align="right">@lang('quickadmin.suppliers.fields.closing_balance')</th>
                    <th colspan="2" style="padding: 10px;border: 1px solid #000;border-top: none;" align="center">{{ $supplier->closing_balance }}</th>
                </tr>
            </tbody>
        </table>
    </main>

@endsection
