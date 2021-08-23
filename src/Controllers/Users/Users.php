<?php

namespace Steodec\Controllers\Users;

use Steodec\Common\ORM;
use Steodec\Common\Utils;
use Steodec\Common\Views;
use Steodec\Attributes\Route;
use Steodec\Model\Models;

class Users
{
    private static function formView(array $params = [])
    {
        $register_inputs = Views::generatedInputs(\Steodec\Entity\Users::class, "register_form");
        $login_inputs = Views::generatedInputs(\Steodec\Entity\Users::class, "login_form");
        $params = array_merge($params, array("register_inputs" => $register_inputs, "login_inputs" => $login_inputs))
        Views::view("Users/form.html.twig", "Formulaire", params: $params);
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

    #[Route(method: "POST", path: "/user/create")]
    public function create()
    {
        $user = Models::Users();
        $userEntity = $user::getSchema();
        foreach ($_POST as $key => $value):
            if (str_starts_with($key, "repeat") && Views::checkRepeat($key, $_POST)):
                unset($_POST[$key]);
            elseif (str_starts_with($key, "repeat")):
                return false;
            else:
                $func = "set_{$key}";
                $userEntity->$func($value);
            endif;
        endforeach;
        $userEntity->set_password(password_hash($userEntity->get_password(), PASSWORD_BCRYPT));
        $userEntity->set_roles(["ROLE_MEMBER"]);
        Models::Users()::create($userEntity);
        return true;
    }
}