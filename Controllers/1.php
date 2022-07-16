<?php

include $_SERVER["DOCUMENT_ROOT"] . "/Model/Wikipedia/Wikipedia.php";
include $_SERVER["DOCUMENT_ROOT"] . "/Model/Database/Tables.php";

header("Content-Type: application/json");
$data = json_decode(file_get_contents("php://input"));

if (empty($data->title)) {
    echo "Введите ключевое слово";
    exit();
}

$api = new Wikipedia;
$db = new Test;

$response = $api->Search($data->title);

for ($i = 0; $i < count($response[1]); $i++) {

    $_title = $response[1][$i];
    $url = $response[3][$i];
    $body = $api->Parse($_title);
    $count = str_word_count($body);

    $rows = $db->Insert("insert into articles (title, wiki_url, count_words) values (?,?,?)",array($_title, $url, $count));

    echo "<tr>";

    if ($rows == 23505) {
        echo "<td>Данная статья есть в базе данных!</td>";
        continue;
    }

    echo "<td>$_title</td>";
    echo "<td>$url</td>";
    echo "<td>$count</td>";
    echo "</tr>";
}



