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


if (empty($data->title)) {
    $msg["status"] = ["Введите ключевое слово"];
    echo json_encode($msg);
    exit();
}

$api = new Wikipedia();
$db = new Database();

$response = $api->Search($data->title);

for ($i = 0; $i < count($response[1]); $i++) {
    $_title = $response[1][$i];
    $url = $response[3][$i];
    $body = $api->Parse($_title);
    $newBody = preg_replace('/[^ a-zа-яё\d]/ui', '', $body);
    $count = str_word_count($newBody);

    $rows = $db->Exec("insert into articles (title, wiki_url, count_words,body) values (?,?,?,?)", [$_title, $url, $count, $body]);
    if ($rows == 23505) {
        $msg["status"][] = "23505";
        $msg["title"][] = $_title;
        continue;
    }

    $msg["status"][] = "ok";
    $msg["title"][] = $_title;
    $msg["url"][] = $url;
    $msg["count"][] = $count;

    foreach (explode(" ", $newBody, $limit = PHP_INT_MAX) as $item) {
        $rows = $db->Exec("insert into words (word,title) values (?,?)", [$item, $_title]);
    }
}

echo json_encode($msg);





