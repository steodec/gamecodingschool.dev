<?php


namespace Steodec\Model;


use Steodec\Common\ORM;

class Users extends ORM
{
    private static ?\Steodec\Entity\Users $_schema = null;
    private static ?self $_instance = null;

    /**
     * @return \Steodec\Entity\Users
     */
    public static function getSchema(): \Steodec\Entity\Users
    {
        if (is_null(self::$_schema)):
            self::$_schema = new \Steodec\Entity\Users();
        endif;
        return self::$_schema;
    }

    /**
     * @return \Steodec\Model\Users
     */
    public static function getInstance(): Users
    {
        if (is_null(self::$_instance)):
            self::$_instance = new self();
        endif;
        return self::$_instance;
    }


}