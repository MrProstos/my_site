<?php

include $_SERVER["DOCUMENT_ROOT"] . "/Model/Database/Database.php";

header("Content-Type: application/json");
$data = json_decode(file_get_contents("php://input"));

if (empty($data->title)) {
    exit();
}

$db = new Database();
$msg = [
    "body" => ""
];
$result = $db->Query("select body from articles where title = ?", [$data->title]);
foreach ($result as $item) {
    $msg["body"] = $item["body"];
}

echo json_encode($msg);

