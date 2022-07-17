"use strict";

const ServerURL = "http://localhost:63342/"

// эта функция сработает при нажатии на кнопку
function Get_Content_1() {

    document.querySelector(".status").innerHTML = "";  //Обновляю тело статуса

    let title = document.querySelector("#title");
    let xhr = new XMLHttpRequest();

    const url = ServerURL + "Controllers/1.php";

    xhr.open("POST", url, true);
    xhr.setRequestHeader("Content-Type", "application/json");
    let data = JSON.stringify({"title": title.value});
    xhr.send(data);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            let msg = JSON.parse(this.response)
            for (let i = 0; i < msg["status"].length; i++) {
                let status = msg["status"][i]
                switch (status) {
                    case "Введите ключевое слово":
                        alert("Введите ключевое слово");
                        break;
                    case "23505":
                        document.querySelector(".status").insertAdjacentHTML("beforeend",
                           ` ${msg["title"][i]}`);
                        break;
                    default :
                        document.querySelector(".status").insertAdjacentHTML("beforeend", msg["title"][i]);
                        document.querySelector(".result_article").insertAdjacentHTML("afterbegin", msg["body"][i]);
                }
            }
        }
    };
}

function Get_Content_2() {

    document.querySelector(".result_article_word").innerHTML = "";  //Обновляю тело статуса

    let word = document.querySelector("#word");
    let result = document.querySelector(".result_article_word");

    let xhr = new XMLHttpRequest();

    const url = ServerURL + "Controllers/2.php";

    xhr.open("POST", url, true);
    xhr.setRequestHeader("Content-Type", "application/json");
    let data = JSON.stringify({"word": word.value})
    xhr.send(data);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            let msg = JSON.parse(this.response)
            for (let i = 0; i < msg["status"].length; i++) {
                let status = msg["status"][i]

                switch (status) {
                    case "Введите слово для поиска":
                        alert("Введите слово для поиска")
                        break
                    case "ok":
                        document.querySelector(".result_article_word").insertAdjacentHTML("beforeend",
                            `<span>Статья ${msg["title"][i]}  кол-во совпадений  ${msg["count"][i]}</span><br>`);
                }

            }
        }
    };
}

