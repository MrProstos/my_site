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
$result = $db->Query("select title,text from articles where text like ?", ["%" . $data->word . "%"]);
foreach ($result as $item) {
    $msg["status"][] = "ok";
    $msg["title"][] = $item["title"] ;
    $msg["count"][] =   substr_count($item["text"],$data->word);
}

echo json_encode($msg);
