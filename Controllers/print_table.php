<?php

include $_SERVER["DOCUMENT_ROOT"] . "/Model/Database/Database.php";

$db = new Database();
$result = $db->Query("SELECT title,wiki_url,count_words FROM articles");
echo "
    <thead>
        <tr>
            <th>Название статьи</th>
            <th>URL</th>
            <th>Кол-во слов</th>
        </tr>
    </thead>";
foreach ($result as $item) {
    echo "
    <tbody>
        <tr>
            <td>{$item["title"]}</td>
            <td>{$item["wiki_url"]}</td>
            <td>{$item["count_words"]}</td>
        </tr>
    </tbody>";
}

