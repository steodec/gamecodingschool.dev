<?php


namespace Steodec\Model;


class Models
{
    public static function Users(): Users
    {
        return Users::getInstance();
    }
}