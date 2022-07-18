<?php

include $_SERVER["DOCUMENT_ROOT"] . "/Model/Database/Database.php";

header("Access-Control-Allow-Origin: *");

$db = new Database();
$result = $db->Query("SELECT title,wiki_url,count_words FROM articles");

$msg = [
    "title" => [],
    "url" => [],
    "count_words" => []
];

foreach ($result as $item) {
    $msg["title"][] = $item["title"];
    $msg["url"][] = $item["wiki_url"];
    $msg["count_words"][] = $item["count_words"];
}

echo json_encode($msg);

