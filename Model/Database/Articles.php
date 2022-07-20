<?php

/**
 * Класс для доступа к таблице Articles
 */
class Articles extends Database
{

    /**
     * @param array $data Принимает массив данных для вставки в БД
     * @return int|null Вернет null в случае успеха, либо код ошибки SQL
     */
    public function Insert(array $data): ?int
    {
        $result = $this->Exec("insert into articles (title, wiki_url, size_byte, cnt_words,article_text) values (?,?,?,?,?)", $data);
        if ($result != null) {

            return $result;
        }

        return null;
    }

    /**
     * @param array $data Принимает массив данных для подставки данных для выполнения условия SQL
     * @return array|bool Вернет array в случае успеха, false если такое записи нет
     */

    public function Select(array $data): array|bool
    {
        return $this->Query("select * from articles where title like ?", $data);
    }

}