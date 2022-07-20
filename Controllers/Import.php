<?php

include $_SERVER["DOCUMENT_ROOT"] . "/Model/Database/Database.php";
include $_SERVER["DOCUMENT_ROOT"] . "/Model/Wikipedia/Wikipedia.php";
include $_SERVER["DOCUMENT_ROOT"] . "/Model/Database/Articles.php";
include $_SERVER["DOCUMENT_ROOT"] . "/Model/Database/Words.php";

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"));

$msg = [
    "status" => [],
    "title" => [],
    "url" => [],
    "size" => [],
    "count" => []
];

//Проверка на отсутсвие данных
if (empty($data->title)) {
    $msg["status"] = ["Введите ключевое слово"];
    echo json_encode($msg);
    exit();
}

new Database();
$api = new Wikipedia();
$articles = new Articles();
$words = new Words();

$response = $api->Search($data->title);
//Парсим массив с данными из Wikipedia

for ($i = 0; $i < count($response[1]); $i++) {

    $_title = $response[1][$i];
    $wiki_url = rawurldecode($response[3][$i]);
    $body = $api->Parse($_title); // Получить текст статьи
    $cleanText = preg_replace('/[^ a-zа-яё\d]/ui', '', $body); // Удалияем спец символы которые остались
    $size = mb_strlen($cleanText, "UNICODE") * 2;
    $cnt_words = str_word_count($cleanText); // Посчитать кол-во слов

    $rows = $articles->Insert([$_title, $wiki_url, $size, $cnt_words,$cleanText]);
    if ($rows == 23000) { // Если такая запись есть, то сообщаем об это пользователю
        $msg["status"][] = 23000;
        $msg["title"][] = $_title;
        continue;
    }

    foreach (explode(" ", $cleanText, $limit = PHP_INT_MAX) as $item) {// Разбиваем текст на слова и проходим циклом
        $words->Insert([$item]);
    }

    $msg["status"][] = "ok";
    $msg["title"][] = $_title;
    $msg["url"][] = $wiki_url;
    $msg["size"][] = $size;
    $msg["count"][] = $cnt_words;
}

echo json_encode($msg);






