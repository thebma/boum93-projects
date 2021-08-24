<?php

//TODO: Why is this called DatabaseAdapter, while it has nothing to do with a database?
class DatabaseAdapter extends Phalcon\Mvc\User\Component
{
    //Converts the JSON Correct string from the database to a php string.
    public function GetCorrect($jsonstring)
    {
        $array = array();
        $json = json_decode($jsonstring, true);

        foreach($json as $key => $value)
        {
            $val = ($value === 1 ? true : false);
            $array[$key] = $val;
        }

        return $array;
    }

    public function GetCorrectInput($jsonstring)
    {
        $array = array();
        $json = json_decode($jsonstring, true);

        foreach($json as $key => $value)
        {
            $array[$key] = $value;
        }

        return $array;
    }
}