@extends('layouts.user')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card mb-3">
                <div class="card-header">
                    <h4>{{ __('Detalhes do Pedido - #') }}{{ $order_details[0]['products']->order_id }}</h4>
                </div>

                <div class="card-body" style="padding: 5%">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="shadow p-3 mb-5 bg-body rounded">
                        <div class="fs-5">Data do Pedido: {{ date("d/m/Y", strtotime($order_details[0]->created_at)) }}</div>
                    </div>
                    <div class="row align-items-start ps-4">
                        <div class="fs-5 col-md-12 mb-3">
                            <table class="table table-sm table-hover">
                                <thead>
                                    <tr>
                                        <td class="w40">Produto</td>
                                        <td class="w25">Preço</td>
                                        <td class="w15">Quant.</td>
                                        <td class="w35">Subtotal</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order_details as $order)
                                    <tr>
                                        <td>{{ $order->name }}</td>
                                        <td>R$ {{ number_format($order->products->price_saled, 2, ',','.') }}</td>
                                        <td>{{ $order->products->qnty_saled }}x</td>
                                        <td>R$ {{ number_format($order->products->price_saled*$order->products->qnty_saled, 2, ',','.') }}</td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="3"></td>
                                        <th class="">R$ {{ number_format($total, 2, ',','.') }}</th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
