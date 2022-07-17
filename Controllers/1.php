<?php

include $_SERVER["DOCUMENT_ROOT"] . "/Model/Wikipedia/Wikipedia.php";
include $_SERVER["DOCUMENT_ROOT"] . "/Model/Database/Database.php";

header("Content-Type: application/json");
$data = json_decode(file_get_contents("php://input"));

$msg = [
    "status"=>[],
    "title"=>[],
    "body"=>[]
];


if (empty($data->title)) {
    $msg["status"] =  ["Введите ключевое слово"];
    echo json_encode($msg);
    exit();
}

$api = new Wikipedia();
$db = new Database();

$response = $api->Search($data->title);
//Цикл сделан
for ($i = 0; $i < count($response[1]); $i++) {
    $_title = $response[1][$i];
    $url = $response[3][$i];
    $body = $api->Parse($_title);
    $count = str_word_count($body);

    $rows = $db->Exec("insert into articles (title, wiki_url, count_words,text) values (?,?,?,?)", [$_title, $url, $count,$body]);

    if ($rows == 23505) {
        $msg["status"][]  = "23505";
        $msg["title"][] = "<span>Cтатья <a href=$url>$_title</a> уже импортирована.</span><br>";
        continue;
    }

    $msg["status"][] = "<p>Импорт завершен!</p>";

    $msg["title"][] = "<span> Найдена статья <a href=$url>$_title</a> Кол-во слов $count</span><br>";

    $msg["body"][]= "
    <tr>
        <td>$_title</td>
        <td>$url</td>
        <td>$count</td>
    </tr>";
}

echo json_encode($msg);





