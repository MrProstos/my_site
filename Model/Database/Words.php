<?php

/**
 * Класс для доступа к таблице Words
 */
class Words extends Database
{
    /**
     * @param array $data Принимает массив данных для вставки в БД
     * @return int|null Вернет null в случае успеха, либо код ошибки SQL
     */
    public function Insert(array $data): ?int
    {
        $result = $this->Exec("insert into words (word) values (?)", $data);
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
        return $this->Query("select * from words where word like ?", $data);
    }

}