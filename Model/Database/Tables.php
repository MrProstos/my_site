<?php

include "Database.php";

class Articles extends Database
{

    function __construct()
    {
        parent::__construct();
    }

    /**
     * Добавление статей в БД
     * @param string $title Название статьи
     * @param string $URL Ссылка
     * @param string $body Тело
     * @return int|null возвращает null в случае успеха
     *
     */

    public function Insert(string $title, string $URL, string $body): ?int
    {
        try {
            $exec = $this->getDBH()->prepare("insert into articles (title, wiki_url, count_words) values (?,?,?)");
            $exec->execute(array($title, $URL, $body));
            return null;
        } catch (PDOException $e) {
            return $e->getCode();
        }
    }

    /**
     * Поиск слов в статье , возрващает Название статьи и тело статьи
     * @param string $Search_word
     * @return bool|array
     */

    public function Search_Word_in_Body(string $Search_word): bool|array
    {
        if ($Search_word == "") {
            return false;
        }
        try {
            $arr = [];
            $query = $this->getDBH()->prepare("SELECT id,title,body FROM wiki_title WHERE title LIKE ?");
            $query->execute(array("%" . $Search_word . "%"));
            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                $arr[] = $row;
            }
            return $arr;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
}

class Test extends Database
{
    public function Insert(string $sql_str,array $data): ?int
    {
        try {
            $exec = $this->getDBH()->prepare($sql_str);
            $exec->execute($data);
            return null;
        } catch (PDOException $e) {
            return $e->getCode();
        }
    }
}
