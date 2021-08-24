<?php
include_once "BaseMessage.php";

class Error extends BaseMessage
{
    public function __construct($message, $name, $redirect=false, $url="/")
    {
        $this->SetMessage($message);

        $this->SetMasterListener("error");
        $this->SetSubListener($name);

        if($redirect)
        {
            $this->Redirect($url);
        }
    }

    public function Render()
    {
        return "<div class='alert alert-danger error' role='alert'>" .  $this->GetMessage() . "</div>";
    }

    public function Log($details)
    {
        //TODO Log message in database
        //TODO LOg message in a file (json format).
    }

    public function Redirect($redirect)
    {
        //TODO Implement redirect method
    }
}