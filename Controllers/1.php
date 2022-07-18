<?php

include $_SERVER["DOCUMENT_ROOT"] . "/Model/Wikipedia/Wikipedia.php";
include $_SERVER["DOCUMENT_ROOT"] . "/Model/Database/Database.php";

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"));

$msg = [
    "status" => [],
    "title" => [],
    "url" => [],
    "count" => []
];

//Проверка на отсутсвие данных
if (empty($data->title)) {
    $msg["status"] = ["Введите ключевое слово"];
    echo json_encode($msg);
    exit();
}

$api = new Wikipedia();
$db = new Database();

$response = $api->Search($data->title);
//Парсим массив с данными из Wikipedia
for ($i = 0; $i < count($response[1]); $i++) {
    $_title = $response[1][$i];
    $url = $response[3][$i];
    $body = $api->Parse($_title); // Получить текст статьи
    $newBody = preg_replace('/[^ a-zа-яё\d]/ui', '', $body); // Удалияем спец символы которые остались
    $count = str_word_count($newBody); // Посчитать кол-во слов

    $rows = $db->Exec("insert into articles (title, wiki_url, count_words,body) values (?,?,?,?)", [$_title, $url, $count, $body]);
    if ($rows == 23505) { // Если такая запись есть то сообщаем об это пользователю
        $msg["status"][] = "23505";
        $msg["title"][] = $_title;
        continue;
    }

    $msg["status"][] = "ok";
    $msg["title"][] = $_title;
    $msg["url"][] = rawurldecode($url); //Преобразуем URL читабельны вид
    $msg["count"][] = $count;

    foreach (explode(" ", $newBody, $limit = PHP_INT_MAX) as $item) { // Разбиваем текст на слова и проходим циклом
        $rows = $db->Exec("insert into words (word,title) values (?,?)", [$item, $_title]);
    }
}

echo json_encode($msg);





