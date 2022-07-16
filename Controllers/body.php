<?php

header("Content-Type: application/json");
$data = json_decode(file_get_contents("php://input"));

if (empty($data->title)) {
    echo "Введите слово для поиска";
    exit();
}
