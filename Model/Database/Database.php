<?php


class Database
{
    private string $host = "localhost";
    private string $port = "5432";
    private string $dbname = "postgres";
    private string $user = "postgres";
    private string $password = "Zz123456";
    private PDO $DBH;

    function __construct()
    {
        try {
            $dsn = "pgsql:host=$this->host;port=$this->port;dbname=$this->dbname;";
            $this->DBH = new PDO($dsn, $this->user, $this->password);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getDBH(): PDO
    {
        return $this->DBH;
    }

    /**
     * Вернет null или код ошибки
     * @param string $sql_str 1-аргумент SQL запрос в виде строки
     * @param array $data 2-аргумент данные (переменные для вставки в SQL запрос)
     * @return int|null
     */

    public function Exec(string $sql_str, array $data): ?int
    {
        try {
            $exec = $this->getDBH()->prepare($sql_str);
            $exec->execute($data);
            return null;
        } catch (PDOException $e) {
            return $e->getCode();
        }
    }

    /**
     * Вернет Массив или false в случае ошибки
     * @param string $sql_str 1-аргумент SQL запрос в виде строки
     * @param array|null $data 2-аргумент данные (переменные для вставки в SQL запрос)
     * @return array|bool
     */

    public function Query(string $sql_str, array $data = null): array|bool
    {
        try {
            $arr = array();
            $query = $this->getDBH()->prepare($sql_str);
            $query->execute($data);
            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                $arr[] = $row;
            }
            return $arr;
        } catch (PDOException $e) {
            return false;
        }
    }
}