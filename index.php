<?php


require "vendor/autoload.php";

use Dotenv\Dotenv;
use Steodec\Router\RouterConfig;
use HaydenPierce\ClassFinder\ClassFinder;

session_start();
date_default_timezone_set("Europe/Paris");
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

RouterConfig::run("Steodec\Controllers");
