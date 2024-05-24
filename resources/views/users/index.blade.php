@extends('layouts.home')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-header d-flex justify-content-between">
                    <div>{{ __('Usuários') }}</div>
                    <div>
                        @if( Auth::user()->user_type_id === 1 )
                            <a href="{{ route('users.user_form') }}" class="size-100 btn btn-success">
                                + Criar Usuário
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

                    <table class="table table-striped table-hover table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="w-20">NOME</th>
                                <th class="w-15">EMAIL</th>
                                <th class="w-10">CPF</th>
                                <th class="w-10 text-center">TIPO</th>
                                <th class="w-15">DEPARTAMENTO</th>
                                <th class="w-10 text-center">DATA DE CRIAÇÃO</th>
                                <th class="w-15 text-center">AÇÕES</th>
                            </tr>
                        </thead>
                        <tbody>

                        @foreach ($users['data'] as $user)
                            <tr>
                                <td class="text-center">{{$user->id}}</td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->cpf}}</td>
                                <td class="text-center">{{$user->user_type->type}}</td>
                                <td class="text-center">{{$user->section->name}}</td>
                                <td class="text-center">{{$user->created_at}}</td>
                                <td class="d-flex justify-content-center">
                                    <div class="w100">
                                        <a href="{{ route('users.view', $user->id) }}" class="w-100 btn btn-primary">
                                            Editar
                                        </a>
                                    </div>
                                    &nbsp;
                                    @if( Auth::user()->user_type_id === 1 )
                                    <div class="w100">
                                        <form method="post" action="{{ route('users.delete', $user->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <input type="submit" value="Excluir" class="w-100 action btn-delete btn btn-danger text-light">
                                        </form>
                                    </div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        @foreach ($users['links'] as $link)
                            <li class="page-item">
                                <a class="page-link" href="{{$link['url']}}">
                                    {{ html_entity_decode($link['label']); }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
@endsection
