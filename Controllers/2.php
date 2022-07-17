<?php


include $_SERVER["DOCUMENT_ROOT"] . "/Model/Wikipedia/Wikipedia.php";
include $_SERVER["DOCUMENT_ROOT"] . "/Model/Database/Tables.php";

header("Content-Type: application/json");
$data = json_decode(file_get_contents("php://input"));

if (empty($data->word)) {
    echo "Введите слово для поиска";
    exit();
}

$db = new Database();
