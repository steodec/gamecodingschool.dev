<?php

namespace Steodec\GamecodingschoolDev\Router;


use HaydenPierce\ClassFinder\ClassFinder;
use ReflectionClass;
use ReflectionException;

class RouterConfig
{
    /**
     * @throws ReflectionException
     */
    public static function registerController(string $controller): array
    {
        $class = new ReflectionClass($controller);
        $routeArray = [];
        foreach ($class->getMethods() as $method) {
            $router = $method->getAttributes(Route::class);
            if (empty($router)) continue;
            foreach ($router as $r) {
                $newRoute = $r->newInstance();
                if (empty($newRoute->getPath()))
                    $newRoute->setPath("/" . $method->name);
                if (empty($newRoute->getMethod()))
                    $newRoute->setMethod("GET");
                $newRoute->setCallable($method->class . "#" . $method->name);
                array_push($routeArray, $newRoute);
            }
        }
        return $routeArray;
    }

    /**
     * @throws RouterException
     * @throws ReflectionException
     * @throws \Exception
     */
    public static function run()
    {
        $classes = ClassFinder::getClassesInNamespace("Steodec\GamecodingschoolDev\Controllers", ClassFinder::RECURSIVE_MODE);
        $routes = [];
        foreach ($classes as $class) {
            $routes = array_merge($routes, self::registerController($class));
        }
        $router = new Router($_GET['url']);
        foreach ($routes as $route) {
            if (empty($route->getIsGranted())):
                $router->add($route->getPath(), $route->getCallable(), $route->getName(), $route->getMethod());
            else:
                if (!isset($_SESSION['user'])) continue;
                if (self::hasPermission($route->getIsGranted())) {
                    $router->add($route->getPath(), $route->getCallable(), $route->getName(), $route->getMethod());
                }
            endif;
        }
        $router->run();
    }

    /**
     * @param string $permission
     *
     * @return bool
     */
    private static function hasPermission(string $permission): bool
    {
        if (!isset($_SESSION['user'])) return false;
        foreach ($_SESSION['user']->getRole() as $role) {
            if ($role->getPermissions()[0] == "*") return true;
            if (in_array($permission, $role->getPermissions())) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param string $namespace
     *
     * @return array
     * @throws \ReflectionException
     */
    public static function getRoute(): array
    {
        $classes = ClassFinder::getClassesInNamespace("Steodec\GamecodingschoolDev\Controllers", ClassFinder::RECURSIVE_MODE);
        $routes = [];
        foreach ($classes as $class) {
            $routes = array_merge($routes, self::registerController($class));
        }
        return $routes;
    }
}