<?php

//Класс для поиска статей
class Wikipedia
{
    const endPoint = "https://ru.Wikipedia.org/w/api.php";

    /**
     * Отрпавка запроса до Wikipedia, возвращает ассоциативный массив
     * @param $params
     * @return mixed
     */

    private function Request($params): mixed
    {
        $url = self::endPoint . "?" . http_build_query($params);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close($ch);
        return json_decode($output, true);
    }

    /**
     * Поиск статей , возвращает ассоциативный массив
     * @param string $Search_word
     * @return mixed
     */

    public function Search(string $Search_word): mixed
    {
        $params = [
            "action" => "opensearch",
            "format" => "json",
            "search" => $Search_word,
            "namespace" => "0",
            "profile" => "strict",
            "redirects" => "resolve",
            "limit" => 5
        ];
        return $this->Request($params);
    }

    /**
     * Получение тела, возвращает статью без HTML тегов
     * @param string $title
     * @return string
     */

    public function Parse(string $title): string
    {
        $params = [
            "action" => "parse",
            "format" => "json",
            "page" => $title,
            "prop" => "text"
        ];
        $arr = $this->Request($params);
        return strip_tags($arr["parse"]["text"]["*"]);
    }
}