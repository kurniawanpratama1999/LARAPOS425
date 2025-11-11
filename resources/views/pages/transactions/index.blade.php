@extends('layouts.dashboard')
@section('title', 'Roles | Larapos 425')
@section('content')
    <table id="datas" class="w-full relative">
        <thead class="sticky top-0 z-1 bg-neutral-200 text-left">
            <tr>
                <th>code</th>
                <th>payment</th>
                <th>items</th>
                <th>subtotal</th>
                <th>tax</th>
                <th>discount</th>
                <th>total</th>
                <th>created</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($datas as $order)
                <tr onclick="showDetail({{ $order->id }})" class="relative hover:bg-black/10 transition-[background]">
                    <td>{{ $order->code }}</td>
                    <td>{{ $order->payment }}{{ $order->payment_tool ? '/' . $order->paymet_tool : '' }}{{ $order->payment_detail ? '/' . $order->paymet_detail : '' }}
                    </td>
                    <td>{{ $order->quantities }}</td>
                    <td>{{ number_format($order->subtotal, 0, ',', '.') }}</td>
                    <td>{{ number_format($order->tax, 0, ',', '.') }}</td>
                    <td>{{ number_format($order->discount, 0, ',', '.') }}</td>
                    <td>{{ number_format($order->total, 0, ',', '.') }}</td>
                    <td>{{ $order->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

@section('btn-group')
    <x-floating-button href="{{ route('transaction.create') }}" id="btn-add" color="green">
        <i class="bi bi-plus text-2xl"></i>
    </x-floating-button>

    <x-floating-button id="btn-print" color="blue" onclick="btnDelete()" type="button" disabled>
        <i class="bi bi-journal-text"></i>
    </x-floating-button>

    <x-floating-button id="btn-cancel-checklist" color="blue" onclick="btnCancelChecklist()" type="button" disabled>
        <i class="bi bi-x"></i>
    </x-floating-button>
@endsection

@pushOnce('scripts')
    <script src="{{ Vite::asset('resources/js/bladeTransactionsMain.js') }}"></script>
@endPushOnce
