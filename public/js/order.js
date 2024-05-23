document.addEventListener("DOMContentLoaded", () => {
    const xhttp = new XMLHttpRequest();
    let order = document.getElementById("order");
    let user_id = document.getElementById("user_id").value;
    console.log(order);
    xhttp.onload = function () {
        const res = JSON.parse(this.response);
        var length = Object.keys(res.data).length;
        let table = "";
        if (order !== null) {
            table += "<thead>";
            table += "<tr>";
            table += "<th class='text-center'>#</th>";
            table += "<th class='w-25'>VENDEDOR</th>";
            table += "<th class='w-15'>CLIENTE</th>";
            table += "<th class='w-10 text-center'>PRODUTO</th>";
            table += "<th class='w-15 text-center'>PREÇO</th>";
            table += "<th class='w-15 text-center'>QUANT.</th>";
            table += "<th class='w-10 text-center'>DATA DA VENDA</th>";
            table += "<th class='w-15 text-center'>AÇÕES</th>";
            table += "</tr>";
            table += "</thead>";
            for (var i = 0; i < length; i++) {
                console.log(i);
                console.log(res.data[i]);
                console.log(res.data[i].product);
                table += "<tbody>";
                table += "<tr>";
                table += "<td class='text-center'>" + res.data[i].id + "</td>";
                table += "<td>" + res.data[i].saler.name + "</td>";
                table += "<td>" + res.data[i].customer.name + "</td>";
                table +=
                    "<td class='text-center'>" + res.data[i].product + "</td>";
                table +=
                    "<td class='text-center'>" +
                    //res.data[i].product.products.price_saled +
                    "</td>";
                table +=
                    "<td class='text-center'>" +
                    //res.data[i].product.products.qnty_saled +
                    "</td>";
                table +=
                    "<td class='text-center'>" +
                    //res.data[i].product.products.qnty_saled +
                    "</td>";
                table +=
                    "<td class='text-center'>" +
                    res.data[i].created_at +
                    "</td>";
                table += "<td class='d-flex justify-content-center'>";
                table += "<div class='w45'>";
                table += "<a href='#' class='w-100 btn btn-primary'>Editar</a>";
                table += "</div>";
                table += "<div class='w45'>";
                table += "<form method='post' action='#'>";
                table += "@csrf";
                table += "@method('DELETE')";
                table +=
                    "<input type='submit' value='Excluir' class='w-100 action btn-delete btn btn-danger text-light'>";
                table += "</form>";
                table += "</div>";
                table += "</td>";
                table += "</tr>";
                table += "</tbody>";
            }
            order.innerHTML = table;
        }
    };

    xhttp.open("GET", "/orders/get_orders/" + user_id, true);
    xhttp.send();
});
