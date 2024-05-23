@extends('layouts.user')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card mb-3">
                <div class="card-header">
                    <h4>{{ __('Criar um Usuário') }}</h4>
                </div>

                <div class="card-body" style="padding: 5%">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('users.create') }}">
                    @csrf
                    <div class="form-group row" id="user_form">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Nome<span class="red">*</span>: </label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <input id="type_value" type="hidden" class="form-control" value="">
                            <input id="section_value" type="hidden" class="form-control" value="">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email<span class="red">*</span>: </label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <br />
                    <div class="form-group row mb-6">
                        <div class="col-md-4 mb-3">
                            <label for="cpf" class="form-label">CPF<span class="red">*</span>: </label>
                            <input id="cpf" type="text" class="form-control @error('cpf') is-invalid @enderror" name="cpf" value="" placeholder="000.000.000-00" maxlength="14" required autocomplete="" autofocus>
                            @error('cpf')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="section" class="form-label">Setor<span class="red">*</span>: </label>
                            <select class="form-select" id="section" name="section_id">

                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="user_type" class="form-label">Tipo<span class="red">*</span>: </label>
                            <select class="form-select" id="type" name="user_type_id">

                            </select>
                        </div>
                    </div>
                    <br />
                    <div class="form-group row">
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label">Senha<span class="red">*</span>: </label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" autofocus>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="password-confirm" class="form-label">Confirmar Senha<span class="red">*</span>: </label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" autofocus>
                        </div>
                    </div>
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
