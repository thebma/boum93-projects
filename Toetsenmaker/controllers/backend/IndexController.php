
<?php

class IndexController extends \Phalcon\Mvc\Controller
{
    public function indexAction()
    {
        $base = new BasicPage(0, "Home");
    }

    public function logoutAction()
    {
        $this->session->destroy();
        $this->response->redirect('/?success=logout');
    }
}