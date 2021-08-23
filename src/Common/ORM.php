<?php


namespace Steodec\Common;


use PDO;

class ORM
{

    private static ?PDO $_db = null;

    /**
     * @return \PDO|null
     */
    public static function getDb(): ?PDO
    {
        if (is_null(self::$_db)):
            self::$_db = new PDO("mysql:host={$_ENV["DB_HOST"]};dbname={$_ENV["DB_DATABASE"]};charset=UTF8", $_ENV["DB_USER"], $_ENV["DB_PASSWORD"]);
        endif;
        return self::$_db;
    }

    public static function create(object $object)
    {
        $query = "INSERT INTO " . $object::TABLE_NAME . " (";
        $queryValues = " VALUES (";
        $values = [];
        foreach ($object as $key => $value):
            if ($key == array_key_last(get_object_vars($object))):
                $query .= $key . ")";
                $queryValues .= "?)";
            else:
                $query .= $key . ", ";
                $queryValues .= "?, ";
            endif;
            if (is_array($value) || is_object($value)):
                $value = json_encode($value);
            endif;
            array_push($values, $value);
        endforeach;
        $query = $query . $queryValues;
        $sql = self::getDb()->prepare($query);
        $sql->execute($values);
        var_dump($sql);
    }


}