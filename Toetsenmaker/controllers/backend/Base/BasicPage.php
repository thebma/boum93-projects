<?php

class BasicPage extends Phalcon\Mvc\User\Component
{
    public $auth;
    public $db;

    public $page;

    public function __construct($authlevel, $page="Toetsen")
    {
        $this->assets
            ->addCss('/css/normalize.css')
            ->addCss('/css/bootstrap.css')
            ->addCss('/css/font-awesome.css')
            ->addCss('/css/index.css');

        $this->assets
            ->addJs('/js/jquery.js')
            ->addJs('/js/bootstrap.js');

        $this->auth = $this->session->get("auth");
        $this->db = $this->getDI()->get('db');

        $this->view->categorie = accordion($this->db);
        $this->view->footer = footer();
        $this->view->docmenu = docmenu($this->auth);
        $this->view->navbar = NavBar($page , $this->auth["lvl"], $this->auth["name"]);

        //Check if the user has access to this page.
        if($this->auth['lvl'] < $authlevel )
        {
           $this->response->redirect('/error403');
        }

        $this->view->error = MessagesManager::Display($_GET);
    }

    public function GetAuth()
    {
        return $this->auth;
    }

    public function GetDB()
    {
        return $this->db;
    }

}



