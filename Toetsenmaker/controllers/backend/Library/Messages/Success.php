<?php
include_once "BaseMessage.php";

class Success extends BaseMessage
{
    public function __construct($message, $name, $redirect=false, $url="/")
    {
        $this->SetMessage($message);

        $this->SetMasterListener("success");
        $this->SetSubListener($name);

        if($redirect)
        {
            $this->Redirect($url);
        }
    }

    public function Render()
    {
        return "<div class='alert alert-success error' role='alert'>" .  $this->GetMessage() . "</div>";
    }

    public function Log($details){}
    public function Redirect($redirect){}
}
?>