<?php

ini_set('session.gc_probability', 1);

//Include basic page and snippets
include_once "../app/controllers/snippets/SnippetWrapper.php"; //TODO: Replace with beter snippet manager
include_once __DIR__ . "/../app/controllers/Base/BasicPage.php";
include_once __DIR__ . "/../app/controllers/Library/Messages/MessagesManager.php";

//Set the timzone for the server.
date_default_timezone_set( "Europe/Amsterdam" );

use Phalcon\Cache\Frontend\Data as FrontendData;
use Phalcon\Cache\Backend\Memcache as BackendMemcache;

try {
    //Register an autoloader
    $loader = new \Phalcon\Loader();
    $loader->registerDirs(array(
        '../app/controllers/',
        '../app/models/'
    ))->register();

    //Create a DI
    $di = new Phalcon\DI\FactoryDefault();

    $di->set('session', function() {
        $session = new Phalcon\Session\Adapter\Files();
        $session->start();
        return $session;
    });
    //Setup dispatcher
    $di->set('dispatcher', function() use ($di) {
        $eventsManager = $di->getShared('eventsManager');
        $eventsManager->attach( "dispatch:beforeException",
            function($event, $dispatcher, $exception)
            {
                switch($exception->getCode())
                {
                    //Handle 404 error.
                    case \Phalcon\Mvc\Dispatcher::EXCEPTION_HANDLER_NOT_FOUND:
                    case \Phalcon\Mvc\Dispatcher::EXCEPTION_ACTION_NOT_FOUND:
                        $dispatcher->forward(array(
                            'controller' => 'error',
                            'action' => 'error404'
                        ));
                        return false;

//                    //Handle error 500 error.
//                    default:
//                        $dispatcher->forward(array(
//                            'controller' => 'error',
//                            'action' => 'error500'
//                        ));
//                        return false;

                }
            }
        );

        $dispatcher = new Phalcon\Mvc\Dispatcher();
        $dispatcher->setEventsManager($eventsManager);
        return $dispatcher;
    }, true);

    //Setup the database service
    $di->set('db', function(){
        return new \Phalcon\Db\Adapter\Pdo\Mysql(array(
            "host" => "localhost",
            "username" => "sprnt_db",
            "password" => "fDrs33FY4vdu7PE4",
            "dbname" => "fcsprint_toets",
            "charset"=> "utf8"
        ));
    });

    //Setup the view component
    $di->set('view', function() {

        $view = new \Phalcon\Mvc\View();

        $view->setViewsDir('../app/views/');

        $view->registerEngines(array(
            ".phtml" => 'Phalcon\Mvc\View\Engine\Volt'
        ));

        return $view;
    });

    //Setup a base URI so that all generated URIs include the "tutorial" folder
    $di->set('url', function(){
        $url = new \Phalcon\Mvc\Url();
        $url->setBaseUri('');
        return $url;
    });

    //Handle the request
    $application = new \Phalcon\Mvc\Application($di);
    echo $application->handle()->getContent();

} catch(\Phalcon\Exception $e) {
    echo "PhalconException: ",  $e->getMessage();
}
