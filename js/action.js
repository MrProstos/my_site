//Обработка клика на название статьи и отправка данных на сервер
function OnClickTitle() {
    $(".title").on("click", function(){
        let id = $(this).attr("id");
        let result = document.querySelector(".get-body");

        let req = new XMLHttpRequest();
        let url = "http://localhost:63342/body.php";

        req.open("POST", url, true);
        req.setRequestHeader("Content-Type", "application/json");

        let data = JSON.stringify({"title": id})

        req.send(data);

        req.onreadystatechange = function () {
            if (req.readyState === 4 && req.status === 200) {
                result.innerHTML = this.responseText;
            }
        };
    });
}