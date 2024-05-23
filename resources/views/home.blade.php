@extends('layouts.home')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="text-center">
                        <div class="row mb-3" style="padding: 2%">
                            <div class="col-md-3">
                                <a href="{{ url('/users') }}" class="w100 btn btn-lg btn-outline-primary">
                                    Usuários
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="{{ url('/products') }}" class="w100 btn btn-lg btn-outline-secondary">
                                    Produtos
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="{{ url('/orders') }}" class="w100 btn btn-lg btn-outline-success">
                                    Vendas
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="{{ url('/home') }}" class="w100 btn btn-lg btn-outline-info">
                                    Relatório
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
