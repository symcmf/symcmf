<?php

require_once(__DIR__ . '/../c3.php');

use Sonata\PageBundle\Request\RequestFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Debug\Debug;

// If you don't want to setup permissions the proper way, just uncomment the following PHP line
// read http://symfony.com/doc/current/setup.html#checking-symfony-application-configuration-and-setup
// for more information
//umask(0000);

// This check prevents access to debug front controllers that are deployed by accident to production servers.
// Feel free to remove this, extend it, or make something more sophisticated.
if (isset($_SERVER['HTTP_CLIENT_IP'])
    || isset($_SERVER['HTTP_X_FORWARDED_FOR'])
    || php_sapi_name() === 'cli-server'
) {
    header('HTTP/1.0 403 Forbidden');
    exit('You are not allowed to access this file. Check '.basename(__FILE__).' for more information.');
}

/** @var \Composer\Autoload\ClassLoader $loader */
$loader = require __DIR__.'/../app/autoload.php';
Debug::enable();

$kernel = new AppKernel('dev', true);

// need to comment for testing
//$kernel->loadClassCache();

// multisite : host (SonataPageBundle)
$request = Request::createFromGlobals();

// multisite: host_with_path (SonataPageBundle)
//$request = RequestFactory::createFromGlobals('host_with_path');

$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
