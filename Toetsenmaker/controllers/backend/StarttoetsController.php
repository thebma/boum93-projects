<?php

class StartToetsController extends \Phalcon\Mvc\Controller
{
    public function indexAction()
    {
        $this->ResetSessions();

        $this->assets
            ->addCss('css/bootstrap.css')
            ->addCss('css/index.css')
            ->addCss('css/starttoets.css')
            ->addCss('css/font-awesome.css');

        $this->assets
            ->addJs('js/jquery.js')
            ->addJs('js/bootstrap.js');

        $toetsid = $this->request->getQuery("toetsid");

        if($this->session->has("auth"))
        {
            $auth = $this->session->get("auth");
            $id = $auth["id"];
            $this->session->set("leerlingid", $id);
        }else
        {
            $ipreadspeaker = "79.136.80.*";
            $range = 256;

            $isInRange = false;
            for($i = 0; $i < $range; $i++)
            {
                $ip = str_replace("*", $i, $ipreadspeaker);
                if($ip == $_SERVER["REMOTE_ADDR"])
                {
                    $isInRange = true;
                }
            }

            if(!$isInRange)
            {
                $this->response->redirect("/error403");
            }
        }

        $toetsconfig = new Toetsconfig();
        $config = $toetsconfig::findFirst($toetsid);

        $title = $config->titel;
        $text = $config->starttext;
        $background = $config->bgimage;

        if($title != "" && $text != "" && $background != "")
        {
            $this->view->background = "<img src='/public/img/toetsen/" . $toetsid . "/" . $background . "' id='background'>";
            $this->view->title= $title;
            $this->view->content = $text;
            $this->view->start = '<a id="start-button" class="btn center-block" href="/vraagtoets">Start</a>';
            $this->view->raw = strip_tags($text);
            $this->session->set("toetsid", $toetsid);
        }
        else
        {
          $this->DoesNotExist();
        }

    }

    public function DoesNotExist()
    {
        $this->view->title = "Helaas";
        $this->view->content = "<b class='text-center'>Er bestaat geen toets met dit ID.</b>";
        $this->view->start = '<a id="start-button" class="btn center-block" href="/">Terug</a>';
        $this->view->background = "<p id='background' class='black'></p>";
    }

    public function ResetSessions()
    {
        if($this->session->has("current"))
        {
            $this->session->remove("current");
        }

        if($this->session->has("previous"))
        {
            $this->session->remove("previous");
        }

        if($this->session->has("vraagid"))
        {
            $this->session->remove("vraagid");
        }

        if($this->session->has("time"))
        {
            $this->session->remove("time");
        }

        if($this->session->has("correct"))
        {
            $this->session->remove("correct");
        }

        if($this->session->has("wrong"))
        {
            $this->session->remove("wrong");
        }

        if($this->session->has("multi_correct"))
        {
            $this->session->remove("multi_correct");
        }
    }


}
