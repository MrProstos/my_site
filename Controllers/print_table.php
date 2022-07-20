<?php

include $_SERVER["DOCUMENT_ROOT"] . "/Model/Database/Database.php";
include $_SERVER["DOCUMENT_ROOT"] . "/Model/Database/Articles.php";

header("Access-Control-Allow-Origin: *");

new Database();
$articles = new Articles();
$result = $articles->Select(["%"]);

$msg = [
    "title" => [],
    "url" => [],
    "size"=>[],
    "count_words" => []
];

foreach ($result as $item) {
    $msg["title"][] = $item["title"];
    $msg["url"][] = $item["wiki_url"];
    $msg["size"][] = $item["size_byte"];
    $msg["count_words"][] = $item["cnt_words"];
}

echo json_encode($msg);

