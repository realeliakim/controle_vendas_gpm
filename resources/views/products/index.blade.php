@extends('layouts.home')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-header d-flex justify-content-between">
                    <div>{{ __('Produtos') }}</div>
                    <div>
                        <a href="{{ route('products.product_form') }}" class="size-100 btn btn-success">
                            + Criar Produto
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
                                <th class="w5 text-center">#</th>
                                <th class="w-25">NOME</th>
                                <th class="w-15">PREÇO</th>
                                <th class="w-10 text-center">ESTOQUE</th>
                                <th class="w-15 text-center">DEPARTAMENTO</th>
                                <th class="w-10 text-center">DATA DE CRIAÇÃO</th>
                                <th class="w-15 text-center">AÇÕES</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($products['data'] as $product)
                            <tr>
                                <td class="text-center">{{$product->id}}</td>
                                <td>{{$product->name}}</td>
                                <td>R$ {{ number_format($product->price, 2, ',','.') }}</td>
                                <td class="text-center">{{$product->stock}}</td>
                                <td class="text-center">{{$product->section->name}}</td>
                                <td class="text-center">{{$product->created_at}}</td>
                                <td class="d-flex justify-content-center">
                                    <div class="w45">
                                        <a href="{{ route('products.view', $product->id) }}" class="w-100 btn btn-primary">
                                            Editar
                                        </a>
                                    </div>
                                    &nbsp;
                                    <div class="w45">
                                        <form method="post" action="{{ route('products.delete', $product->id) }}">
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
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        @foreach ($products['links'] as $link)
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
