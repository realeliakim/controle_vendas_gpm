document.addEventListener("DOMContentLoaded", () => {
    const xhttp = new XMLHttpRequest();
    let type = document.getElementById("type_value");
    xhttp.onload = function () {
        const res = JSON.parse(this.response);
        var length = res.data.length;
        var option = "";
        if (type !== null) {
            for (var i = 0; i < length; i++) {
                if (type.value == i + 1) {
                    option +=
                        "<option value='" +
                        res.data[i].id +
                        "' selected>" +
                        res.data[i].type +
                        "</option>";
                } else {
                    option +=
                        "<option value='" +
                        res.data[i].id +
                        "'>" +
                        res.data[i].type +
                        "</option>";
                }
            }
            document.getElementById("type").innerHTML = option;
        }
    };

    xhttp.open("GET", "/user_types", true);
    xhttp.send();
});
