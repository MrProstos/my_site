"use strict";

const ServerURL = "http://localhost:63342/"

// эта функция сработает при нажатии на кнопку
function Get_Content_1() {

    let title = document.querySelector("#title");
    let result = document.querySelector(".result_article");
    let xhr = new XMLHttpRequest();

    const url = ServerURL + "Controllers/1.php";

    xhr.open("POST", url, true);
    xhr.setRequestHeader("Content-Type", "application/json");
    let data = JSON.stringify({"title": title.value});
    xhr.send(data);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            alert(this.response)
            switch (this.responseText) {
                case "23505":
                    alert("Данная статья уже присутствует!");
                    break;
                case "Введите ключевое слово":
                    alert(this.responseText);
                    break;
                default:
                    result.insertAdjacentHTML("beforeend", this.responseText);
            }
        }
    };
}

function Get_Content_2() {
    let word = document.querySelector("#word");
    let result = document.querySelector(".result_content_2");

    let xhr = new XMLHttpRequest();

    const url = ServerURL + "Controllers/2.php";

    xhr.open("POST", url, true);
    xhr.setRequestHeader("Content-Type", "application/json");
    let data = JSON.stringify({"word": word.value})
    xhr.send(data);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            result.innerHTML = this.responseText;
        }
    };
}

