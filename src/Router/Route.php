<?php


namespace Steodec\GamecodingschoolDev\Router;


class Route
{
    private string $_path;
    private $_callable;
    private array $_matches = [];
    private array $_params = [];

    /**
     * Route constructor.
     *
     * @param $path
     * @param $callable
     */
    public function __construct($path, $callable)
    {
        $this->_path = trim($path, '/');
        $this->_callable = $callable;
    }

    /**
     * @return mixed
     */
    public function call(): mixed
    {
        if (is_string($this->_callable)) {
            $params = explode('#', $this->_callable);
            $controller = $params[0];
            $controller = new $controller();
            return call_user_func_array([$controller, $params[1]], $this->_matches);
        } else {
            return call_user_func_array($this->_callable, $this->_matches);
        }
    }

    /**
     * @param $url
     *
     * @return bool
     */
    public function match($url): bool
    {
        $url = trim($url, '/');
        $path = preg_replace('#:([\w]+)#', '([^/]+)', $this->_path);
        $regex = "#^$path$#i";
        if (!preg_match($regex, $url, $matches)) {
            return false;
        }
        array_shift($matches);
        $this->_matches = $matches;
        return true;
    }
}