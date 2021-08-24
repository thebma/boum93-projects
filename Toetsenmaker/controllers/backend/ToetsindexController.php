<?php

class ToetsindexController extends \Phalcon\Mvc\Controller
{
    public function indexAction()
    {
        $this->assets
            ->addCss('css/starttoets.css');

        $this->assets
            ->addJs('js/jquery.js')
            ->addJs('js/bootstrap.js');

        if(!$this->session->has("auth"))
        {
            $this->response->redirect("/login");
        }

        $id = $this->request->getQuery('id');
        $background = $this->GetBackground($id);

        if($background != "")
        {
            $this->view->background = "<img src='/public/img/index/" . $id . "/" . $background . "' id='background'>";
            $this->view->title= $this->GetTitle($id);
            $this->view->content = $this->GetText($id);

            $toetsen = $this->GetToetsen($id);

            foreach($toetsen as $toets)
            {
                $this->view->start .= "<a id='toets-button' class='btn col-md-6' href='/starttoets?toetsid=" . $toets['id'] . "'> " . $toets["toetsnaam"] . "</a>";
            }
        }
        else
        {
            $this->DoesNotExist();
        }

    }

    public function GetBackground($userid)
    {
        $phql = "SELECT bgimage FROM toetsindex WHERE userid = '".$userid."' LIMIT 1";
        $db = $this->getDI()->get('db');
        $result = $db->query($phql)->fetch();

        return $result["bgimage"];
    }

    public function GetTitle($userid)
    {
        $phql = "SELECT title FROM toetsindex WHERE userid = '".$userid."' LIMIT 1";
        $db = $this->getDI()->get('db');
        $result = $db->query($phql)->fetch();

        return $result["title"];
    }

    public function GetText($userid)
    {
        $phql = "SELECT starttext FROM toetsindex WHERE userid = '".$userid."' LIMIT 1";
        $db = $this->getDI()->get('db');
        $result = $db->query($phql)->fetch();

        return $result["starttext"];
    }

    public function GetToetsen($userid)
    {
        $phql = "SELECT id, toetsnaam FROM toetsen WHERE users_id = '".$userid."'";
        $db = $this->getDI()->get('db');
        $result = $db->query($phql)->fetchAll();

        return $result;
    }


    public function DoesNotExist()
    {
        $this->view->title = "Helaas";
        $this->view->content = "<b class='text-center'>Er bestaat geen leraar met dit ID.</b>";
        $this->view->start = '<a id="start-button" class="btn center-block" href="/">Terug</a>';
        $this->view->background = "<p id='background' class='black'></p>";
    }
}


?>