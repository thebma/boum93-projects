<?php

class TimeManager extends Phalcon\Mvc\User\Component
{
    private $startTimestamp;
    private $endTimestamp;

    //Intialize the TimeManager to calculate end time and start time.
    public function Intialize($timedbstr)
    {
        if($this->endTimestamp == null && $this->startTimestamp == null)
        {
            $this->startTimestamp = strtotime("now");
            $this->endTimestamp = strtotime($this->GetTimeString($timedbstr));
        }
    }

    //Format the string to be accepted into strtotime.
    private function GetTimeString($str)
    {
        $part = explode(":", $str);
        return "+" . $part[0] . " hour +" . $part[1] . " minutes +" . $part[2] . " seconds";
    }


    //Reset the time variables so the time can get reset for the next exam.
    public function ResetTime()
    {
        $this->startTimestamp = null;
        $this->endTimestamp = null;
    }

    //Return the timestamp when the time started.
    public function GetStartTime()
    {
        return $this->startTimestamp;
    }

    //Return the calculated end time of the exam/test.
    public function GetEndTime()
    {
        return $this->endTimestamp;
    }

    //Get the difference of the timestamps and format it to hour, second, minute.
    public function GetTime()
    {
        $diff = strtotime("now") - $this->startTimestamp;

        return gmdate("H:i:s", $diff);
    }

    public function GetTimeRemaining()
    {
        $diff = $this->endTimestamp - strtotime("now");

        return gmdate("H:i:s", $diff);
    }


    //Boolean variable to see if the timer has counted down.
    public function IsDone()
    {
        return json_encode((strtotime("now") >= $this->endTimestamp));
    }

    public function GetAllTimeAttributes()
    {
        return strtotime("now") . "," . $this->endTimestamp . "," . $this->IsDone();
    }


}