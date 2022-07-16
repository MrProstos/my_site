// эта функция сработает при нажатии на кнопку
function sendJSON_Content_1() {
    // с помощью jQuery обращаемся к элементам на странице по их именам
    let title = document.querySelector("#title");
    // а вот сюда мы поместим ответ от сервера
    let result = document.querySelector(".result_content_1");
    // создаём новый экземпляр запроса XHR
    let xhr = new XMLHttpRequest();
    // адрес, куда мы отправим JSON-строку
    const url = "http://localhost:63342/Controllers/1.php";
    // открываем соединение
    xhr.open("POST", url, true);
    // устанавливаем заголовок — выбираем тип контента, который отправится на сервер, в нашем случае мы явно пишем, что это JSON
    xhr.setRequestHeader("Content-Type", "application/json");
    // преобразуем наши данные JSON в строку
    let data = JSON.stringify({"title": title.value});
    // когда всё готово, отправляем JSON на сервер
    xhr.send(data);
    // когда придёт ответ на наше обращение к серверу, мы его обработаем здесь
    xhr.onreadystatechange = function () {
        // если запрос принят и сервер ответил, что всё в порядке
        if (xhr.readyState === 4 && xhr.status === 200) {
            // выводим то, что ответил нам сервер — так мы убедимся, что данные он получил правильно
            result.innerHTML = this.responseText;
        }
    };
}

function sendJSON_Content_2() {
    let word = document.querySelector("#word");
    let result = document.querySelector(".result_content_2");

    let req = new XMLHttpRequest();
    const url = "http://localhost:63342/Controllers/2.php";

    req.open("POST", url, true);
    req.setRequestHeader("Content-Type", "application/json");

    let data = JSON.stringify({"word": word.value})

    req.send(data);

    req.onreadystatechange = function () {
        if (req.readyState === 4 && req.status === 200) {
            result.innerHTML = this.responseText;
        }
    };
}

