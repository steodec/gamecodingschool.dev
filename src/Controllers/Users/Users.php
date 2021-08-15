<?php

namespace Steodec\Controllers\Users;

use Steodec\Common\Utils;
use Steodec\Common\Views;
use Steodec\Attributes\Route;

class Users
{
    private static function formView()
    {
        Views::view("Users/form.html.twig", "Formulaire");
    }

    private static function myProfil()
    {
        Views::view("Users/form.html.twig", "Mon Profile");
    }

    #[Route(path: "/user")]
    public function index()
    {
        if (Utils::isLogged()):
            self::myProfil();
        else:
            self::formView();
        endif;
    }
}