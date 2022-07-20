"use strict";

const ServerURL = "http://localhost:63342/"

// При нажатии кнопки отправляет запрос на сервер
function Get_Content_1() {

    document.querySelector(".status").innerHTML = "";  //Обновляю тело статуса

    let title = document.querySelector("#title"); // Берем название статьи введеное пользователем
    let xhr = new XMLHttpRequest();

    const url = ServerURL + "Controllers/Import.php";

    xhr.open("POST", url, true);
    xhr.setRequestHeader("Content-Type", "application/json");
    let data = JSON.stringify({"title": title.value});
    xhr.send(data); // Отправляем данные в виде JSON

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            let msg = JSON.parse(this.response)
            for (let i = 0; i < msg["status"].length; i++) { //Парсим ответ и вставляем в HTML

                let status = msg["status"][i];
                let title = msg["title"][i];
                let url = msg["url"][i];
                let size = Math.trunc(msg["size"][i] / 1000);
                let count = msg["count"][i];

                switch (status) {
                    case "Введите ключевое слово":
                        alert("Введите ключевое слово");
                        break;
                    case 23000:
                        document.querySelector(".status").insertAdjacentHTML("beforeend",
                            `<span>Статья ${title} уже импортирована</span><br>`);
                        break;
                    case "ok" :
                        console.log(title)
                        document.querySelector(".status").insertAdjacentHTML("beforeend",
                            `<span>Статья <a href=${url}>${title}</a> импортирована, кол-во слов ${count}</span><br>`);
                        document.querySelector(".table").insertAdjacentHTML("afterbegin",
                            `
                        <tr>
                            <td>${title}</td>
                            <td>${url}</td>
                            <td>${size}Kb</td>
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

    const url = ServerURL + "Controllers/Search.php";

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
                let word = msg["word"][i];
                let count = msg["count"][i];

                switch (status) {
                    case "Введите слово для поиска":
                        alert("Введите слово для поиска")
                        break
                    case "ok":
                        document.querySelector(".result_article_word").insertAdjacentHTML("beforeend",
                            `<span>Слово ${word} - статья <a id="${title}" onclick="OnClickTitle()" href="#">${title}</a>  кол-во совпадений  ${count}</span><br>`);
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

function Clean_body() {
    document.querySelector(".get-body").innerHTML = ""
}

function OnLoad() {
    let result = document.querySelector(".table");

    let req = new XMLHttpRequest();
    const url = ServerURL + "Controllers/print_table.php";

    req.open("GET", url, true);
    req.send(null);

    req.onreadystatechange = function () {
        if (req.readyState === 4 && req.status === 200) {
            let msg = JSON.parse(this.response)
            for (let i = 0; i < msg["title"].length; i++) {

                let title = msg["title"][i];
                let url = msg["url"][i];
                let size = Math.trunc(msg["size"][i] / 1000);
                let count = msg["count_words"][i];

                result.insertAdjacentHTML("afterbegin", `
                <tbody class="table-group-divider">
                        <tr>
                            <td>${title}</td>
                            <td>${url}</td>
                            <td>${size}Kb</td>
                            <td>${count}</td>
                        </tr>
                    </tbody>`);

            }

        }
    };
}

