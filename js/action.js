"use strict";

//Обработка клика на название статьи и отправка данных на сервер
function OnClickTitle(el) {
    console.log(el.id);
    // let id = document.querySelector(".url").id
    // console.log(id)
    // let result = document.querySelector(".get-body");
    //
    // let req = new XMLHttpRequest();
    // const url = "http://localhost:63342/body.php";
    //
    // req.open("POST", url, true);
    // req.setRequestHeader("Content-Type", "application/json");
    //
    // let data = JSON.stringify({"title": id})
    //
    // req.send(data);
    //
    // req.onreadystatechange = function () {
    //     if (req.readyState === 4 && req.status === 200) {
    //         result.innerHTML = this.responseText;
    //     }
    // };

}

function OnLoad() {
    let result = document.querySelector(".result_article");

    let req = new XMLHttpRequest();
    let url = "http://localhost:63342/Controllers/print_table.php";

    req.open("GET", url, true);
    req.send(null);

    req.onreadystatechange = function () {
        if (req.readyState === 4 && req.status === 200) {
            result.insertAdjacentHTML("beforeend", this.responseText);
        }
    };
}
