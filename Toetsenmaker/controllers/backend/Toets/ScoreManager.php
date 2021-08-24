<?php

class ScoreManager extends Phalcon\Mvc\User\Component
{
    private $questionmanager;

    private $correct = 1;
    private $wrong = 1;

    //Construct ScoreManager, dependency inject the question manager.
    public function __construct(QuestionManager $questionmanager)
    {
        $this->questionmanager = $questionmanager;
    }

    //Loop thru the array, count how many questions were correct.
    public function GetCorrect()
    {
        $questionarray = $this->questionmanager->GetQuestionArray();
        $count = 0;

        /** @var @var $question QuestionContainer */
        foreach($questionarray as $question)
        {
            $result = $question->GetResult();
            if($result == QuestionContainer::QUESTION_CORRECT)
            {
                $count++;
            }
        }

        return $count;
    }

    //Loop thru the array, count how many questions were wrong.
    public function GetWrong()
    {
        $questionarray = $this->questionmanager->GetQuestionArray();
        $count = 0;

        /** @var @var $question QuestionContainer */
        foreach($questionarray as $question)
        {
            $result = $question->GetResult();
            if($result == QuestionContainer::QUESTION_WRONG || $result == QuestionContainer::QUESTION_SKIPPED)
            {
                $count++;
            }
        }

        return $count;
    }

    //Loop thru the array, count how many questions were skipped.
    public function GetSkipped()
    {
        $questionarray = $this->questionmanager->GetQuestionArray();
        $count = 0;

        /** @var @var $question QuestionContainer */
        foreach($questionarray as $question)
        {
            $result = $question->GetResult();
            if($result == QuestionContainer::QUESTION_SKIPPED)
            {
                $count++;
            }
        }

        return $count;
    }
}
