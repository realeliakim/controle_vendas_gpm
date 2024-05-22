document.addEventListener("DOMContentLoaded", () => {
    const xhttp = new XMLHttpRequest();
    let section = document.getElementById("section_value");
    xhttp.onload = function () {
        const res = JSON.parse(this.response);
        var length = res.data.length;
        var option = "";
        for (var i = 0; i < length; i++) {
            if (section.value == i + 1) {
                option +=
                    "<option value='" +
                    res.data[i].id +
                    "' selected>" +
                    res.data[i].name +
                    "</option>";
            } else {
                option +=
                    "<option value='" +
                    res.data[i].id +
                    "'>" +
                    res.data[i].name +
                    "</option>";
            }
        }
        document.getElementById("section").innerHTML = option;
    };

    xhttp.open("GET", "/sections", true);
    xhttp.send();
});
