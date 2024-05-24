window.onload = function () {
    const cpf = document.getElementById("cpf");
    if (cpf !== null) {
        cpf.addEventListener("input", (e) => {
            e = e.target.value;
            e = e.replace(/\D/g, "");
            e = e.replace(/(\d{3})(\d)/, "$1.$2");
            e = e.replace(/(\d{3})(\d)/, "$1.$2");
            e = e.replace(/(\d{3})(\d{1,2})$/, "$1-$2");
            cpf.value = e;
        });
    }

    const price = document.getElementById("price");
    if (price !== null) {
        price.addEventListener("input", (e) => {
            e = e.target.value;
            e = e.replace(".", "").replace(",", "").replace(/\D/g, "");

            const options = { minimumFractionDigits: 2 };
            const result = new Intl.NumberFormat("pt-BR", options).format(
                parseFloat(e) / 100
            );
            price.value = result;
        });
    }
};

function cart(id, name, price, stock) {
    price = +price;
    let cart = document.getElementById("cart");
    cart.style.display = "block";
    let button = document.getElementById(id);
    let prod_stock = document.getElementById(name);
    let counter = document.getElementById("counter_" + id);
    let subtotal = document.getElementById("subtotal");
    if (button.id === id) {
        counter.value++;
        prod_stock.value--;
        subtotal.value = +subtotal.value + price;
        if (prod_stock.value == 0) {
            button.disabled = true;
        } else {
            button.disabled = false;
        }
    }
    subtotal = +subtotal.value;
    let html = "";
    let total = "";
    let calc = counter.value * price;
    html +=
        '<table class="pb-2" style="border-collapse: separate; border-spacing: 2px">';
    html += '<tr class="fs-6" id="item_' + id + '">';
    html += '<td class="w30">' + name + "</td>";
    html +=
        '<td class="w30">' +
        price.toLocaleString("pt-BR", { style: "currency", currency: "BRL" }) +
        "</td>";
    html += '<td class="w5 text-center">' + counter.value + "x</td>";
    html +=
        '<td class="w35">&nbsp; ' +
        calc.toLocaleString("pt-BR", { style: "currency", currency: "BRL" }) +
        "</td>";
    html +=
        '<input type="hidden" class="form-control" name="product_id[]" value="' +
        id +
        '" required>';
    html +=
        '<input type="hidden" class="form-control" name="qnty_saled[]" value="' +
        counter.value +
        '" required>';
    html +=
        '<input type="hidden" class="form-control" name="price_saled[]" value="' +
        price +
        '" required>';
    html += "</tr>";
    html += "</table>";

    total += '<table class="pb-4 w-100">';
    total += '<tr class="fs-6">';
    total += '<td class="ps-1 w40 fs-4">TOTAL</td>';
    total +=
        '<td class="w60 text-center fs-4">' +
        subtotal.toLocaleString("pt-BR", {
            style: "currency",
            currency: "BRL",
        }) +
        "</td>";
    total += "</tr>";
    total += "</table>";
    let item_id = document.getElementById("item_" + id);
    let total_element = document.getElementById("total");

    total_element.innerHTML = total;
    item_id.innerHTML = html;
}
