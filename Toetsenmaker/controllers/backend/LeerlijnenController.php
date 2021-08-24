<?php

class LeerlijnenController extends \Phalcon\Mvc\Controller
{
    public function indexAction()
    {
        $base = new BasicPage(2, "Leerlijnen");
        $this->assets->addCss('/css/leerlijnen.css');
    }
}

?>