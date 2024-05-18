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
                    <div style="text-align: center">
                        <div class="row mb-3" style="padding: 0 12%">
                            <div class="col-md-3">
                                <a href="{{ url('/users') }}" class="size-100 btn btn-lg btn-outline-primary">
                                    Usuário
                                </a>
                            </div>
                            <div class="col-md-3">
                                <button type="button" class="size-100 btn btn-lg btn-outline-secondary">Produtos</button>
                            </div>
                            <div class="col-md-3">
                                <button type="button" class="size-100 btn btn-lg btn-outline-success">Venda</button>
                            </div>
                            <div class="col-md-3">
                                <button type="button" class="btn btn-lg btn-outline-info" style="width: 100%">Info</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
