<?php

namespace Steodec\Controllers\Users;

use Steodec\Common\Utils;
use Steodec\Common\Views;
use Steodec\Attributes\Route;

class Users
{
    private static function formView()
    {
        $register_inputs = Views::generatedInputs(\Steodec\Entity\Users::class, "register_form");
        $login_inputs = Views::generatedInputs(\Steodec\Entity\Users::class, "login_form");
        Views::view("Users/form.html.twig", "Formulaire", params: array("register_inputs" => $register_inputs, "login_inputs" => $login_inputs));
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