"use strict";

const ServerURL = "http://mrprostos.keenetic.link/"

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
                let title = msg["title"][i]
                let url = msg["url"][i]
                let count = msg["count"][i]

                switch (status) {
                    case "Введите ключевое слово":
                        alert("Введите ключевое слово");
                        break;
                    case "23505":
                        document.querySelector(".status").insertAdjacentHTML("beforeend",
                            `<span>Статья ${title} уже импортирована</span><br>`);
                        break;
                    case "ok" :
                        document.querySelector(".status").insertAdjacentHTML("beforeend",
                            `<span>Статья<a href=${url}>${title}</a> импортирована, кол-во слов ${count}</span><br>`);
                        document.querySelector(".result_article").insertAdjacentHTML("afterbegin",
                            `
                        <tr>
                            <td>${title}</td>
                            <td>${url}</td>
                            <td>${count}</td>
                        </tr>`);
                }
            }
        }
    };
}

function Get_Content_2() {

    document.querySelector(".result_article_word").innerHTML = "";  //Обновляю тело статуса

    let word = document.querySelector("#word");

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
                let title = msg["title"][i];
                let count = msg["count"][i];

                switch (status) {
                    case "Введите слово для поиска":
                        alert("Введите слово для поиска")
                        break
                    case "ok":
                        document.querySelector(".result_article_word").insertAdjacentHTML("beforeend",
                            `<span>Статья <a id="${title}" onclick="OnClickTitle()" href="#">${title}</a>  кол-во совпадений  ${count}</span><br>`);
                }

            }
        }
    };
}


//Обработка клика на название статьи и отправка данных на сервер
function OnClickTitle() {
    document.querySelector('.result_article_word').addEventListener('click', function (e) {
        let id = e.target.id;
        let result = document.querySelector(".get-body")

        let req = new XMLHttpRequest();
        const url = ServerURL + "Controllers/body.php";

        req.open("POST", url, true);
        req.setRequestHeader("Content-Type", "");

        let data = JSON.stringify({"title": id});

        req.send(data);

        req.onreadystatechange = function () {
            if (req.readyState === 4 && req.status === 200) {
                result.innerHTML = this.response;
            }
        }
    });

}

function OnLoad() {
    let result = document.querySelector(".result_article");

    let req = new XMLHttpRequest();
    const url = ServerURL + "Controllers/print_table.php";

    req.open("GET", url, true);
    req.send(null);

    req.onreadystatechange = function () {
        if (req.readyState === 4 && req.status === 200) {
            result.insertAdjacentHTML("beforeend", this.responseText);
        }
    };
}

