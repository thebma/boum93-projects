<?php
include_once "BaseMessage.php";

class Info extends BaseMessage
{
    public function __construct($message, $name, $redirect=false, $url="/")
    {
        $this->SetMessage($message);

        $this->SetMasterListener("info");
        $this->SetSubListener($name);

        if($redirect)
        {
            $this->Redirect($url);
        }
    }

    public function Render()
    {
        return "<div class='alert alert-info error' role='alert'>" .  $this->GetMessage() . "</div>";
    }

    public function Log($details){}
    public function Redirect($redirect){}
}
?>