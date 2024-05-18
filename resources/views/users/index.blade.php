@extends('layouts.home')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-header d-flex justify-content-between">
                    <div>{{ __('Usuários') }}</div>
                    <div>
                        <a href="{{ route('users.create') }}" class="size-100 btn btn-success">
                            + Criar Usuário
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <table class="table table-striped table-hover table-bordered">
                        <thead>
                            <tr>
                            <th class="w5 center" scope="col">#</th>
                            <th class="w30 center" scope="col">NOME</th>
                            <th class="w15 center" scope="col">EMAIL</th>
                            <th class="w15 center" scope="col">CPF</th>
                            <th class="w15 center" scope="col">TIPO</th>
                            <th class="w20 center" scope="col">DATA DE CRIAÇÃO</th>
                            <th class="w30 center" scope="col">AÇÕES</th>
                            </tr>
                        </thead>
                        <tbody>

                        @foreach ($users as $user)
                            <tr>
                            <td class="center" scope="row">{{$user->id}}</td>
                            <td class="center" scope="row">{{$user->name}}</td>
                            <td class="center" scope="row">{{$user->email}}</td>
                            <td class="center" scope="row">{{$user->created_at}}</td>

                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
