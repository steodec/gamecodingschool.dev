<?php

namespace Steodec\Common;

use Twig\TwigFilter;
use ReflectionClass;
use Twig\Environment;
use Twig\TwigFunction;
use ReflectionProperty;
use ReflectionException;
use Twig\Error\LoaderError;
use Twig\Error\SyntaxError;
use Steodec\Attribute\Form;
use Twig\Error\RuntimeError;
use Steodec\Router\RouterConfig;
use Twig\Loader\FilesystemLoader;
use Twig\Extension\DebugExtension;
use Twig\Extra\String\StringExtension;

class Views
{
    /**
     * @param string $template
     * @param string $title
     * @param array  $params
     *
     * @throws ReflectionException
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public static function view(string $template, string $title, array $params = [])
    {
        if (!str_contains($template, ".")):
            $template = $template . "/index.html.twig";
        elseif (!str_ends_with($template, ".twig")):
            $template = $template . ".twig";
        endif;
        $loader = new FilesystemLoader(Constants::VIEWS_PATH);
        $paramLoad = [];
        $twig = new Environment($loader, $paramLoad);
        (is_null($params)) ? $params = ["TITLE" => $title . " — " . Constants::PROJECT_NAME] : $params["TITLE"] = $title
            . " — "
            .
            Constants::PROJECT_NAME;
        $params["assets"] = Constants::ASSETS_PATH;
        $params["css"] = Constants::CSS_PATH;
        $params["js"] = Constants::JS_PATH;
        $params['routes'] = RouterConfig::getRoute("Steodec/Controllers");
        $twig->addExtension(new DebugExtension());
        $twig->addExtension(new StringExtension());
        $twig->addFilter(new TwigFilter('json_decode', function ($string) {
            return json_decode($string);
        }));
        $twig->addFilter(new TwigFilter('json_encode', function ($string) {
            return json_encode($string);
        }));
        $twig->addFilter(new TwigFilter('escape_quotes', function ($string) {
            $string = str_replace("'", "\\'", $string);
            return str_replace('"', '\\"', $string);
        }));
        $twig->addFunction(new TwigFunction('has_permission', function ($string) {
            return self::hasPermission($string);
        }));

        $page = $twig->load($template);
        echo $page->render($params);
    }

    private static function hasPermission(string $permission): bool
    {
        if (!isset($_SESSION['user'])) return FALSE;
        foreach ($_SESSION['user']->getRole() as $role) {
            if ($role->getPermissions()[0] == "*") return TRUE;
            if (in_array($permission, $role->getPermissions())) {
                return TRUE;
            }
        }
        return FALSE;
    }

    /**
     * @param object|class-string $Object
     *
     * @throws ReflectionException
     */
    public static function generatedInputs(object|string $Object)
    {
        $class = new ReflectionClass($Object);
        $routeArray = [];
        foreach ($class->getProperties() as $property):
            $inputs = $property->getAttributes(Form::class);
            if (empty($inputs)) continue;
            foreach ($inputs as $input):
                $input = $input->newInstance();
                if (!$input->is_hidden()):
                    $label = ucfirst($input->get_name());
                    echo "<label for='{$input->get_name()}'>{$label}</label>";
                    echo "<input  name='{$input->get_name()}' type='{$input->get_type()}' id='{$input->get_name()}'/>";
                    if ($input->is_checked()):
                        $label = ucfirst("repeat " . $input->get_name());
                        echo "<label for='{$input->get_name()}'>{$label}</label>";
                        echo "<input  name='{$input->get_name()}' type='{$input->get_type()}'/>";
                    endif;
                endif;
            endforeach;
        endforeach;

    }

}