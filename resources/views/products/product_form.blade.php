@extends('layouts.user')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card mb-3">
                <div class="card-header">
                    <h4>{{ __('Criar Produto') }}</h4>
                </div>

                <div class="card-body" style="padding: 5%">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('products.create') }}">
                    @csrf
                    <div class="form-group row" id="user_form">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Nome do produto<span class="red">*</span>: </label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <input id="section_value" type="hidden" class="form-control" value="">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="price" class="form-label">Preço<span class="red">*</span>: </label>
                            <input id="price" type="text" class="form-control @error('price') is-invalid @enderror" name="price" value="{{ old('price') }}" required autocomplete="price" autofocus>
                            @error('price')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <br />
                    <div class="form-group row">
                        <div class="col-md-6 mb-3">
                            <label for="stock" class="form-label">Estoque<span class="red">*</span>: </label>
                            <input id="stock" type="text" class="form-control @error('stock') is-invalid @enderror" name="stock" required autocomplete="" autofocus>
                            @error('stock')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="section" class="form-label">Departamento<span class="red">*</span>: </label>
                            <select class="form-select" id="section" name="section_id">

                            </select>
                        </div>
                    </div>
                    <br />
                    <br />
                    <div class="form-group row mb-3">
                        <div class="row justify-content-center">
                            <button type="submit" class="w-50 btn btn-success" id="btn-submit">
                            {{ __('Salvar') }}
                            </button>
                            &nbsp;
                        </div>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
