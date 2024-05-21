document.addEventListener("DOMContentLoaded", () => {
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function () {
        const res = JSON.parse(this.response);
        var length = res.data.length;
        var option = "";
        for (var i = 0; i < length; i++) {
            option +=
                "<option value='" +
                res.data[i].id +
                "'>" +
                res.data[i].name +
                "</option>";
        }
        document.getElementById("section").innerHTML = option;
    };

    xhttp.open("GET", "/sections", true);
    xhttp.send();
});
