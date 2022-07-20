<?php

include $_SERVER["DOCUMENT_ROOT"] . "/Model/Database/Database.php";
include $_SERVER["DOCUMENT_ROOT"] . "/Model/Database/Articles.php";

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"));

if (empty($data->title)) {
    exit();
}

new Database();
$article = new Articles();
$result = $article->Select([$data->title]);

echo $result[0]["article_text"];

