<?php


namespace Steodec\GamecodingschoolDev\Router;

use Exception;
use JetBrains\PhpStorm\Pure;

class RouterException extends Exception
{

    /**
     * RouterException constructor.
     * @param string $string
     */
    #[Pure] public function __construct(string $string)
    {
        parent::__construct($string);
    }
}