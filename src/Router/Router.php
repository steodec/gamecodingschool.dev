<?php


namespace Steodec\GamecodingschoolDev\Router;

class Router
{
    private string $_url;
    private array $_routes = [];
    private array $_namedRoutes = [];

    /**
     * Router constructor.
     *
     * @param string $url
     */
    public function __construct(string $url)
    {
        $this->_url = $url;
    }

    /**
     * @param $path
     * @param $callable
     * @param $name
     * @param $method
     *
     * @return \Steodec\GamecodingschoolDev\Router\Route
     */
    public function add($path, $callable, $name, $method): Route
    {
        $route = new Route($path, $callable);
        $this->_routes[$method][] = $route;
        if (is_string($callable) && $name === null) {
            $name = $callable;
        }
        if ($name) {
            $this->_namedRoutes[$name] = $route;
        }
        return $route;
    }

    /**
     * @throws \Steodec\GamecodingschoolDev\Router\RouterException
     */
    public function run(): mixed
    {
        if (!isset($this->_routes[$_SERVER['REQUEST_METHOD']])) {
            throw new RouterException('REQUEST_METHOD does not exist');
        }
        foreach ($this->_routes[$_SERVER['REQUEST_METHOD']] as $route) {
            if ($route instanceof Route)
                if ($route->match($this->_url)) {
                    return $route->call();
                }
        }
        header("HTTP/1.0 404 Not Found");
        return false;
    }

    /**
     * @throws \Steodec\GamecodingschoolDev\Router\RouterException
     */
    public function url($name, $params = [])
    {
        if (!isset($this->namedRoutes[$name])) {
            throw new RouterException('No route matches this name');
        }
        return $this->_namedRoutes[$name]->getUrl($params);
    }

}