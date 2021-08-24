<?php

include_once "Error.php";
include_once "Warning.php";
include_once "Info.php";
include_once "Success.php";

class MessagesManager extends Phalcon\Mvc\User\Component
{
    //Check if the singleton was initialized.
    protected static $isInitialized = false;

    //Hold all the classes we want to be displayed
    protected static $errors = array();
    protected static $infos = array();
    protected static $success = array();
    protected static $warning = array();


    //Initialize all the classes and set initialized to true.
    protected static function Initialize()
    {
        self::InitErrors();
        self::InitInfos();
        self::InitSuccess();
        self::InitWarning();

        self::$isInitialized = true;
    }

    //Create all the errors messages.
    protected static function InitErrors()
    {
        array_push( MessagesManager::$errors, new Error("Ongeldige gegevens ingevuld", "credentials") );
        array_push( MessagesManager::$errors, new Error("De ingevulde gebruiker bestaat niet", "login_user") );
        array_push( MessagesManager::$errors, new Error("Kon de geselecteerde toets niet verwijderen!", "delete_toets") );
    }

    //Create all the infos messages.
    protected static function InitInfos()
    {
        //array_push( MessagesManager::$infos, new Info("Een super vette infos", "test") );
    }

    //Create all the success messages.
    protected static function InitSuccess()
    {
        array_push( MessagesManager::$success, new Success("U bent nu succesvol ingelogd.", "login") );
        array_push( MessagesManager::$success, new Success("U bent nu succesvol uitgelogd.", "logout") );
        array_push( MessagesManager::$success, new Success("Wijzigingen succesvol doorgevoerd.", "edit") );
        array_push( MessagesManager::$success, new Success("Successvol een nieuwe toets aangemaakt.", "new_toets") );
        array_push( MessagesManager::$success, new Success("Successvol toets verwijderd", "delete_toets") );
    }

    //Create all the warning messages.
    protected static function InitWarning()
    {
       array_push( MessagesManager::$warning, new Warning("Er is geen antwoord ingevuld of aangeklikt. Klik overslaan om de vraag over te slaan!", "no_answer") );
    }

    //Check if intialized, check for all the errors, success, info and warning messages.
    public static function Display($get)
    {
        if(!self::$isInitialized)
        {
            self::Initialize();
        }

        $html = '';

        foreach(MessagesManager::$errors as $error)
        {
            if(isset($get[$error->GetMasterListener()]))
            {
                if($get[$error->GetMasterListener()] == $error->GetSubListener())
                {
                   $html .= $error->Render();
                }
            }
        }

        foreach(MessagesManager::$warning as $warning)
        {
            if(isset($get[$warning->GetMasterListener()]))
            {
                if($get[$warning->GetMasterListener()] == $warning->GetSubListener())
                {
                    $html .= $warning->Render();
                }
            }
        }

        foreach(MessagesManager::$infos as $info)
        {
            if(isset($get[$info->GetMasterListener()]))
            {
                if($get[$info->GetMasterListener()] == $info->GetSubListener())
                {
                    $html .= $info->Render();
                }
            }
        }

        foreach(MessagesManager::$success as $success)
        {
            if(isset($get[$success->GetMasterListener()]))
            {
                if($get[$success->GetMasterListener()] == $success->GetSubListener())
                {
                    $html .= $success->Render();
                }
            }
        }

        return $html;
    }

}

?>