<?php

namespace Steodec\Common;

class Utils
{
    /**
     * @return bool
     */
    public static function isLogged(): bool
    {
        return (isset($_SESSION['user']));
    }
}