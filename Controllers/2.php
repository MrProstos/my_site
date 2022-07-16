<?php


include $_SERVER["DOCUMENT_ROOT"] . "/Model/Wikipedia/Wikipedia.php";
include $_SERVER["DOCUMENT_ROOT"] . "/Model/Database/Tables.php";

header("Content-Type: application/json");
$data = json_decode(file_get_contents("php://input"));

if (empty($data->word)) {
    echo "Введите слово для поиска";
    exit();
}

$table_words = new Table_wiki_words();
$table_title = new Articles();

$result = $table_title->Search_Word_in_Body($data->word);
if (!$result) {
    echo "error";
    exit();
}

foreach ($result as $item) {
    $title = $item["title"];
    $n = substr_count($item["body"], $data->word);
    echo "<span onclick='OnClickTitle()' class='title' id='{$title}'><b>{$title}</b> кол-во совпадений {$n}</span><br>";
    /*
    $row = $table_words->Insert($item["id"],$data->word,$n);
    if (!$row) {
        echo "error";
    }*/
}
