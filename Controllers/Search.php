<?php

include $_SERVER["DOCUMENT_ROOT"] . "/Model/Wikipedia/Wikipedia.php";
include $_SERVER["DOCUMENT_ROOT"] . "/Model/Database/Database.php";
include $_SERVER["DOCUMENT_ROOT"] . "/Model/Database/Articles.php";
include $_SERVER["DOCUMENT_ROOT"] . "/Model/Database/Words.php";
include $_SERVER["DOCUMENT_ROOT"] . "/Model/Database/Articles_Words.php";

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"));


$msg = [
    "status" => [],
    "word"=>[],
    "title" => [],
    "count" => []
];


//Проверка на отсутствие данных
if (empty($data->word)) {
    $msg["status"] = ["Введите слово для поиска"];
    echo json_encode($msg);
    exit();
}

$lower_search_word = mb_strtolower($data->word,"UTF-8");

new Database();
$article = new Articles();
$words = new Words();
$article_words = new Articles_Words();

$result_word = $words->Select([$lower_search_word]); //Берем данные из представления которое объединяет таблицу article и words
if (!$result_word) {
    $msg["status"][] = "Такого слова нету";
    echo json_encode($msg);
    exit();
}

$result_article = $article->Select(["%"]);
foreach ($result_article as $item => $value) {

    $cnt = substr_count($value["article_text"], " " . $result_word[0]["word"] . " ");

    foreach ($result_word as $wor_id=>$word_value) {

        $article_words->Insert([$value["id"],$word_value["id"],$cnt]);
    }

}

$result_article_words = $article_words->Select([$lower_search_word]);
foreach ($result_article_words as $item=>$value) {
    if ($value["cnt"] == 0) {
        continue;
    }
    $msg["status"][] = "ok";
    $msg["title"][] = $value["title"];
    $msg["word"][] = $value["word"];
    $msg["count"][]  = $value["cnt"];
}

echo json_encode($msg);