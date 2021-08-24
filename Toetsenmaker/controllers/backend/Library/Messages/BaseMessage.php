<?php

abstract class BaseMessage
{
    private $message;
    private $url;

    private $masterListener;
    private $subListener;

    /*
     * Message properties
     */
    public function SetMessage($msg)
    {
        $this->message = $msg;
    }

    public function GetMessage()
    {
        return $this->message;
    }

    /*
     * Url properties
     */
    public function SetUrl($url)
    {
        $this->url = $url;
    }

    public function GetUrl()
    {
        return $this->url;
    }

    /*
     * I.e. ?error           =  anerror
     *      ?[masterlistener]=[sublistener]
     */
    public function SetMasterListener($identifier)
    {
        $this->masterListener = $identifier;
    }

    public function GetMasterListener()
    {
        return $this->masterListener;
    }

    public function SetSubListener($identiefier)
    {
        $this->subListener = $identiefier;
    }

    public function GetSubListener()
    {
        return $this->subListener;
    }

    /*
     * Render: Render the message out to the screen
     * Log: Store given error on server/database.
     * Redirect: Redirect to url if necessary.
     */
    abstract public function Render();
    abstract public function Log($details);
    abstract public function Redirect($redirect);
}


?>