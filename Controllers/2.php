<?php


include $_SERVER["DOCUMENT_ROOT"] . "/Model/Wikipedia/Wikipedia.php";
include $_SERVER["DOCUMENT_ROOT"] . "/Model/Database/Database.php";

header("Content-Type: application/json");
$data = json_decode(file_get_contents("php://input"));

$msg = [
    "status" => [],
    "title" => [],
    "count" => []
];


if (empty($data->word)) {
    $msg["status"] = ["Введите слово для поиска"];
    echo json_encode($msg);
    exit();
}

$db = new Database();

$result = $db->Query("select title,word,count(word) as count_word from words where word like ? group by title, word order by count_word desc", [$data->word]);
foreach ($result as $item) {
    $msg["status"][] = "ok";
    $msg["title"][] = $item["title"];
    $msg["count"][] = $item["count_word"];
}

echo json_encode($msg);
