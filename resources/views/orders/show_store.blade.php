@extends('layouts.home')

@section('content')
<div class="pt-4 container">
    <div class="row justify-content-center p-1">
        <div class="left col-md-8">
            <h3>Lista de produtos</h3>
            <div class="pt-4 row mb-3">
                @foreach ($products as $product)
                <div class="p-4 col-md-4 text-center shadow-sm border-top border-bottom border-end border-1">
                    <img src="{{ asset('assets/images/produto.png') }}" class="rounded w-75 shadow-lg" alt="produto">
                    <div class="{{ $product->id }}">
                        <div class="fs-4">{{ $product->name }}</div>
                        <div class="fs-5 pb-2">R$ {{ number_format($product->price, 2, ',', '.') }}</div>
                        <input type="hidden" value="{{ $product->stock }}" id="{{ $product->name }}">
                        <input type="hidden" value="0" id="counter_{{ $product->id }}">
                        <input type="button" id="{{ $product->id }}"
                               class="w-75 btn btn-success fs-5"
                               value="Comprar"
                               onclick="cart('{{$product->id}}','{{$product->name}}','{{$product->price}}','{{$product->stock}}')"
                        >
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <div class="right col-md-4 text-center shadow p-3 mb-5 rounded" id="cart" style="display: none; background-color: #E0E0D2">
            <div class="pt-5 row mb-3">
            <h4>Detalhes do pedido</h4>
                <div class="ps-4 pt-5 row mb-3">
                    <form method="POST" action="{{ route('orders.create') }}">
                        @csrf
                        <div class="form-group row">
                            @foreach ($products as $product)
                            <div id="item_{{$product->id}}">
                            </div>
                            @endforeach
                            <input type="hidden" id="subtotal" value="0">
                        </div>
                        <br />
                        <hr />
                        <div id="total">
                        </div>
                        <hr />
                        <br />
                        <br />
                        <div class="mb-3 text-start">
                            <label class="form-label">Selecionar Cliente: </label>
                            <select class="form-select" id="customer_id" name="customer_id" required autocomplete="" autofocus>
                                <option value=""></option>
                                @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <br />
                        <br />
                        <button type="submit" class="fs-5 btn btn-primary w-100">
                            Executar Venda
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


<script>
    function cart(id, name, price, stock) {
        price = +price;
        let cart = document.getElementById('cart');
        cart.style.display = 'block';
        let button = document.getElementById(id);
        let prod_stock = document.getElementById(name);
        let counter = document.getElementById('counter_'+id);
        let subtotal = document.getElementById('subtotal');
        let description = document.getElementById('description');
        if (button.id === id) {
            counter.value++
            prod_stock.value--;
            subtotal.value = +subtotal.value + price;
            if (prod_stock.value == 0) {
                button.disabled = true;
            } else {
                button.disabled = false;
            }
        }
        subtotal = +subtotal.value;
        let html = '';
        let total = '';
        let calc = counter.value * price;
        html += '<table class="pb-2" style="border-collapse: separate; border-spacing: 2px">';
        html += '<tr class="fs-6" id="item_'+id+'">';
        html += '<td class="w30">'+name+'</td>';
        html += '<td class="w30">'+price.toLocaleString("pt-BR", {style:"currency", currency:"BRL"})+'</td>';
        html += '<td class="w5 text-center">'+counter.value+'x</td>';
        html += '<td class="w35">&nbsp; '+calc.toLocaleString("pt-BR", {style:"currency", currency:"BRL"})+'</td>';
        html += '<input type="hidden" class="form-control" name="product_id[]" value="'+id+'" required>';
        html += '<input type="hidden" class="form-control" name="qnty_saled[]" value="'+counter.value+'" required>';
        html += '<input type="hidden" class="form-control" name="price_saled[]" value="'+price+'" required>';
        html += '</tr>'
        html += '</table>';

        total += '<table class="pb-4 w-100">';
        total += '<tr class="fs-6">';
        total += '<td class="ps-1 w40 fs-4">TOTAL</td>';
        total += '<td class="w60 text-center fs-4">'+subtotal.toLocaleString("pt-BR", {style:"currency", currency:"BRL"})+'</td>';
        total += '</tr>';
        total += '</table>';
        let item_id = document.getElementById('item_'+id);
        let total_element = document.getElementById('total');

        total_element.innerHTML = total;
        item_id.innerHTML = html;
    }
</script>

