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
