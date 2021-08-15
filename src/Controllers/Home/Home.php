<?php


namespace Steodec\Controllers\Home;

use Steodec\Common\Views;
use Steodec\Attributes\Route;

class Home
{
    #[Route(path: "/")]
    public function index()
    {
        Views::view("Home", "Accueil");
    }
}