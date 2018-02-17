<?php
/**
 * Created by PhpStorm.
 * Project: chat
 * User: m.benhenda
 * Date: 15/02/2018
 * Time: 23:25
 */
require 'vendor/autoload.php';
use Symfony\Component\HttpFoundation\Request;
use Kernel\Kernel;

$em = new \Kernel\EntityManager();

$request = Request::createFromGlobals();
$kernel = new Kernel();
$response = $kernel->handle($request);
$response->send();

