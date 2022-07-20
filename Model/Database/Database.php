<?php

/**
 * Класс подключение к БД
 */
class Database
{
    private string $host = "127.0.0.1";
    private string $dbname = "db";
    private string $user = "vlad";
    private string $password = "bktl57m";
    private PDO $DBH;

    function __construct()
    {
        try {
            $dsn = "mysql:host={$this->host};dbname=$this->dbname";
            $this->DBH = new PDO($dsn, $this->user, $this->password);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    /**
     * @return PDO
     */

    protected function getDBH(): PDO
    {
        return $this->DBH;
    }

    /**
     * Вернет null или код ошибки
     * @param string $sql_str 1-аргумент SQL запрос в виде строки
     * @param array $data 2-аргумент данные (переменные для вставки в SQL запрос)
     * @return int|null
     */

    protected function Exec(string $sql_str, array $data): ?int
    {
        try {
            $exec = $this->getDBH()->prepare($sql_str);
            $exec->execute($data);
            return null;
        } catch (PDOException $e) {
//            echo $e->getMessage(); // TODO потом удалить
            return $e->getCode();
        }
    }

    /**
     * Вернет Массив или false в случае ошибки
     * @param string $sql_str 1-аргумент SQL запрос в виде строки
     * @param array|null $data 2-аргумент данные (переменные для вставки в SQL запрос)
     * @return array|bool
     */

    protected function Query(string $sql_str, array $data = null): array|bool
    {
        try {
            $arr = array();
            $query = $this->getDBH()->prepare($sql_str);
            $query->execute($data);
            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                $arr[] = $row;
            }
            return $arr;
        } catch (PDOException) {
            return false;
        }
    }
}

