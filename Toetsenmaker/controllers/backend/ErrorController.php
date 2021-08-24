<?php

class ErrorController extends \Phalcon\Mvc\Controller
{
    /*
     * Handle the 404 errors, view: error404.phtml.
     * Error: Page not found
     */
    public function error404Action()
    {
        $base = new BasicPage(0);
        $this->response->setHeader(404, 'Not Found');
    }

    /*
     * Handle the 500 errors, view: error500.phtml
     * Error: when there is an internal server error.
     */
    public function error500Action()
    {
        $base = new BasicPage(0);
        $this->response->setHeader(500, 'Internal Server Error');
    }

    /*
     * Handle 403 errors, view: error403.phtml
     * Error: When user has insufficient permissions
     */
    public function error403Action()
    {
        $base = new BasicPage(0);
        $this->response->setHeader(403, 'Forbidden');
    }
}
?>