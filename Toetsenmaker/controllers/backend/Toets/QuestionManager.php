<?php

include_once "QuestionCreator.php";

class QuestionManager extends Phalcon\Mvc\User\Component
{
    //Holds an array of the QuestionContainer.
    private $questionarray = array();

    //Current index of the questions.
    private $currentIndex = 0;

    //Hold a boolean to see if it is initialized.
    private $initalized = false;

    //Fetch all available questions and pick a random question.
    public function Initialize($id, $config, $type)
    {
        if(!$this->initalized)
        {
            $rawQuestions = Toetsvragen::find(array(
                "toetsen_id = '$id'"
            ));

            $questionArray = array();
            foreach ($rawQuestions as $row)
            {
                array_push($questionArray, $row);
            }

            $creator = new QuestionCreator();
            $this->questionarray = $creator->CreateArray($questionArray, $config->aantalvragen, $type);
            $this->initalized = true;
        }
    }

    public function NextQuestion()
    {
        if($this->currentIndex < (count($this->questionarray) - 1))
        {
            $this->currentIndex++;
            return true;
        }
        else
        {
            return false;
        }
    }

    //Go to the previous question
    public function PreviousQuestion()
    {
        if($this->currentIndex >= 1)
        {
            $this->currentIndex--;
            return true;
        }
        else
        {
            return false;
        }
    }

    //Generate the previous button
    public function GetPreviousButton()
    {
        if($this->currentIndex >= 1)
        {
            return '<input type="submit" id="previousbutton" name="action" value="Vorige">';
        }
        else
        {
            return "";
        }
    }

    //Generate a skip button.
    public function GetSkipButton()
    {
        if($this->currentIndex <= (count($this->questionarray) - 1))
        {
            return '<input type="submit" id="skipbutton" name="action" value="Overslaan">';
        }
        else
        {
            return "";
        }
    }

    //Generate a next button.
    public function GetNextButton()
    {
        if($this->currentIndex <= (count($this->questionarray) - 1))
        {
            return '<input type="submit" id="nextbutton" name="action" value="Volgende">';
        }
        else
        {
            return "";
        }
    }

    public function GetEndButton()
    {
        if($this->currentIndex >= (count($this->questionarray) - 1))
        {
            return '<input type="submit" id="endbutton" name="action" value="Beëindig">';
        }
        else
        {
            return "";
        }
    }

    //Fetch the current QuestionContainer.
    public function CurrentQuestion()
    {
        if(array_key_exists($this->currentIndex, $this->questionarray))
        {
            return $this->questionarray[$this->currentIndex];
        }
        else
        {
            return "0";
        }

    }

    //Fetch the array of questions
    public function GetQuestionArray()
    {
        return $this->questionarray;
    }

    //Check if the question manager has been initalized.
    public function IsInitalized()
    {
        return $this->initalized;
    }

    //Get the current index of the questions.
    public function GetIndex()
    {
        return $this->currentIndex;
    }



}
