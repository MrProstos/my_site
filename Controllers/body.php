<?php

include $_SERVER["DOCUMENT_ROOT"] . "/Model/Database/Database.php";

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"));

if (empty($data->title)) {
    exit();
}

$db = new Database();
$result = $db->Query("select body from articles where title = ?", [$data->title]);

echo $result[0]["body"];

