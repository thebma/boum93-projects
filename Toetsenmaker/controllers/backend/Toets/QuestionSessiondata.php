<?php

class QuestionSessiondata extends Phalcon\Mvc\User\Component
{
    //Get the session from the start toets and fetches toets id.
    public function GetToetsid()
    {
        $id = 0;
        if(!$this->session->has("toetsid"))
        {
            $this->response->redirect("/starttoets?toetsid=-1");
        }else
        {
            $id = $this->session->get("toetsid");
        }

        return $id;
    }

    /** Questionmanager session data. */
    //Sets the class reference of the question manager
    public function SetQuestionManager($questionmanager)
    {
        if(!$this->session->has("questionmanager"))
        {
            $this->session->set("questionmanager", $questionmanager);
            return true;
        }

        return false;
    }

    //Gets the class reference of the question manager
    public function GetQuestionManager()
    {
        if ($this->session->has("questionmanager"))
        {
            return $this->session->get("questionmanager");
        }

        return null;
    }

    //Checks if it has a session set.
    public function HasQuestionManager()
    {
        return $this->session->has("questionmanager");
    }

    /** ScoreManager question data. */
    //Sets the class reference of the question manager
    public function SetScoresManager($scoresmanager)
    {
        return $this->session->set("scoresmanager", $scoresmanager);
    }

    //Gets the class reference of the question manager
    public function GetScoresManager()
    {
        return $this->session->get("scoresmanager");
    }

    //Checks if it has a session set.
    public function HasScoresManager()
    {
        return $this->session->has("scoresmanager");
    }

    /** TimeManager session data */
    //Sets the class reference of the time manager
    public function SetTimeManager(TimeManager $timeManager)
    {
        return $this->session->set("timemanager", $timeManager);
    }

    //Gets the class reference of the time manager
    public function GetTimeManager()
    {
        return $this->session->get("timemanager");
    }

    //Checks if it has a session set.
    public function HasTimeManager()
    {
        return $this->session->has("timemanager");
    }
}