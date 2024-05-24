@extends('layouts.home')

@section('content')
<div class="pt-4 container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-header d-flex justify-content-between">
                    <div>{{ __('Pedidos') }}</div>
                    <div>
                        @if( Auth::user()->user_type_id !== 3 )
                            <a href="{{ route('orders.show_store') }}" class="size-100 btn btn-success">
                                + Realizar Venda
                            </a>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if( Auth::user()->user_type_id === 1 )
                        <form method="POST" action="{{ route('orders.get_orders') }}" class="pt-4 pb-4">
                            @csrf
                            <div class="form-group row">
                                <div class="row col-md-6 mb-3">
                                    <div class="col-md-8 mb-3">
                                        <select class="form-select" id="search" name="user_id">
                                            <option value=""></option>
                                            @foreach ($salers as $saler)
                                                <option value="{{ $saler->id }}">{{ $saler->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <input type="submit" class="btn btn-primary w100" value="Filtar Vendedor">
                                    </div>
                                </div>
                            </div>
                        </form>
                    @endif
                    @if (count($orders['data']) > 0 )
                    <table class="table table-striped table-hover table-bordered">
                        <thead>
                            <tr>
                                <th class="w10 text-center">ID PEDIDO</th>
                                <th class="w20">VENDEDOR</th>
                                <th class="w20">CLIENTE</th>
                                <th class="w20 text-center">DATA DA VENDA</th>
                                <th class="w25 text-center">AÇÕES</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($orders['data'] as $order)
                            <tr>
                                <td class="text-center">{{$order->id}}</td>
                                <td>{{ $order->saler->name}}</td>
                                <td>{{ $order->customer->name }}</td>
                                <td class="text-center">{{ date("d/m/Y", strtotime($order->created_at))}}</td>
                                <td class="d-flex justify-content-center">
                                    <div class="w45">
                                        <a href="{{ route('orders.view', $order->id) }}" class="w-100 btn btn-secondary">
                                            Detalhes
                                        </a>
                                    </div>
                                    &nbsp;
                                    <div class="w45">
                                        <form method="post" action="{{ route('orders.delete', $order->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <input type="submit" value="Excluir" class="w-100 action btn-delete btn btn-danger text-light">
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <nav aria-label="Page navigation" class="pt-3 pb-4">
                    <ul class="pagination justify-content-center">
                        @foreach ($orders['links'] as $link)
                            <li class="page-item">
                                <a class="page-link" href="{{$link['url']}}">
                                    {{ html_entity_decode($link['label']); }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </nav>
                    @else
                        <div class="col-md-12">
                            @if ( Auth::user()->user_type_id === 3 )
                                <h4>Nenhum pedido feito</h4>
                            @else
                                <h4>Nenhuma venda realizada</h4>
                            @endif
                        </div>
                    @endif
            </div>
        </div>
    </div>
</div>
@endsection
