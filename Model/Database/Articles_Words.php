<?php

/**
 * Класс для доступа к таблице Articles_Words
 */

class Articles_Words extends Database
{
    /**
     * @param array $data [int,int,int] Принимает массив данных для вставки в БД
     * @return int|null Вернет null в случае успеха, либо код ошибки SQL
     */

    public function Insert(array $data): ?int
    {
        $result = $this->Exec("insert into articles_words (id_article, id_word, cnt) values (?,?,?)", $data);
        if ($result != null) {

            return $result;
        }

        return null;
    }

    /**
     * @param array $data Принимает массив данных для подставки данных для выполнения условия SQL
     * @return bool|array Вернет array в случае успеха, false если такое записи нет
     */

    public function Select(array $data): bool|array
    {
        return $this->Query("select distinct a.title, w.word, cnt
                                    from articles_words
                                        inner join articles a on articles_words.id_article = a.id
                                        inner join words w on articles_words.id_word = w.id
                                    where w.word like ?
                                    order by cnt desc", $data);
    }


}