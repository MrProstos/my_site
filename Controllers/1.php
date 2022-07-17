<?php

include $_SERVER["DOCUMENT_ROOT"] . "/Model/Wikipedia/Wikipedia.php";
include $_SERVER["DOCUMENT_ROOT"] . "/Model/Database/Database.php";

header("Content-Type: application/json");
$data = json_decode(file_get_contents("php://input"));

if (empty($data->title)) {
    echo "Введите ключевое слово";
    exit();
}

$api = new Wikipedia;
$db = new Database();

$response = $api->Search($data->title);

$msg = [
    "status"=>"",
    "body"=>[]
];

for ($i = 0; $i < count($response[1]); $i++) {

    $_title = $response[1][$i];
    $url = $response[3][$i];
    $body = $api->Parse($_title);
    $count = str_word_count($body);

    $rows = $db->Exec("insert into articles (title, wiki_url, count_words) values (?,?,?)", array($_title, $url, $count));

    if ($rows == 23505) {
        echo 23505;
        continue;
    }
    $msg["body"][]= "<tr>
        <td>$_title</td>
        <td>$url</td>
        <td>$count</td>
    </tr>";
    echo "<tr>
        <td>$_title</td>
        <td>$url</td>
        <td>$count</td>
    </tr>";
}



