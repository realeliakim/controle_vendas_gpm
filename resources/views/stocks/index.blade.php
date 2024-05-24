@extends('layouts.home')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card mb-3">
                <div class="card-header d-flex justify-content-between">
                    <div>{{ __('Relatório Estoque de Produtos') }}</div>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="text-center">
                    <table class="table table-hover">
                        @foreach ($data as $value)
                        <div class="accordion" id="accordionStock">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading{{ $value['id'] }}">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $value['id'] }}" aria-expanded="false" aria-controls="collapse{{ $value['id'] }}">
                                    <span class="w20">{{ $value['name'] }}</span><span class="w10">Estoque atual:</span>{{ $value['stock'] }}
                                </button>
                                </h2>
                                <div id="collapse{{ $value['id'] }}" class="accordion-collapse collapse show" aria-labelledby="heading{{ $value['id'] }}" data-bs-parent="#accordionStock">
                                    @foreach ($value['register'] as $register)
                                    <div class="accordion-body">
                                        <div class="row">
                                            <div class="col-md-7 text-start ps-4">Ação: {{ $register['action'] }}</div>
                                            <div class="col-md-5 text-start">Resultado: {{ $register['reaction'] }}</div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
