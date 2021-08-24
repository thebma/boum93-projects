<?php

include_once "QuestionContainer.php";
include_once "QuestionCreator.php";
include_once "DatabaseAdapter.php";

class QuestionCheck extends Phalcon\Mvc\User\Component
{
    /**
     * @var $questionmanager QuestionManager
     */
    private $questionmanager;

    /**
     * @var $questionelements QuestionCreator
     */
    private $questioncreator;

    /**
     * @var $adapter DatabaseAdapter
     */
    private $adapter;

    public function Check(QuestionManager $questionmanager, $type)
    {
        //Dependency inject the score and question manager.
        $this->questionmanager = $questionmanager;

        //Create a new instance of QuestionElements.
        $this->questioncreator = new QuestionCreator();

        //Create a new adapter.
        $this->adapter = new DatabaseAdapter();

        //Check if the user has entered an answer
        if($type == 1)
        {
            if(!$this->request->hasPost("answer"))
            {
                $this->response->redirect("/vraagtoets?warning=no_answer");
                return false;
            }
        }
        else
        {
            $questions = $this->questionmanager->CurrentQuestion()->GetAnswersCount();
            $hasAnswered = false;

            for($i = 0; $i < $questions; $i++)
            {
                if($type == 3)
                {
                    if ($this->request->getPost("answer" . $i) != "")
                    {
                        $hasAnswered = true;
                        break;
                    }
                }
                elseif($type == 2)
                {
                    if ($this->request->hasPost("answer" . $i))
                    {
                        $hasAnswered = true;
                        break;
                    }
                }
            }

            if(!$hasAnswered)
            {
                $this->response->redirect("/vraagtoets?warning=no_answer");
                return false;
            }
        }

        //Resolve which type we want to check.
        if(is_numeric($type))
        {
            switch ($type)
            {
                case 1:
                    return $this->CheckSingleQuestion();
                case 2:
                    return $this->CheckMultipleQuestion();
                case 3:
                    return $this->CheckInputQuestion();
            }
        }

        return null;
    }


    private function CheckSingleQuestion()
    {
        /** @var $question QuestionContainer */
        $question = $this->questionmanager->CurrentQuestion();
        $correct = $this->adapter->GetCorrect( $question->GetCorrect() );
        $answer = $this->request->getPost("answer");

        return $this->StoreResult($correct[$answer], $answer);
    }

    private function CheckMultipleQuestion()
    {
        /** @var $question QuestionContainer */
        $question = $this->questionmanager->CurrentQuestion();
        $correct = $this->adapter->GetCorrect( $question->GetCorrect() );
        $answers = array();

        //Create an array of true and false of the current answers.
        for($i = 0; $i < $question->GetAnswersCount(); $i++)
        {
            $id = "answer" . $i;
            if($this->request->hasPost($id))
            {
                array_push($answers, true);
            }
            else
            {
                array_push($answers, false);
            }
        }

        //Compare these witth the correct array.
        $isCorrect = true;
        for($n = 0; $n < count($answers); $n++)
        {
            if($answers[$n] != $correct[$n])
            {
                $isCorrect = false;
                break;
            }
        }

        return $this->StoreResult($isCorrect, $answers);
    }

    private function CheckInputQuestion()
    {
        /** @var $question QuestionContainer */
        $question = $this->questionmanager->CurrentQuestion();
        $correct = $this->adapter->GetCorrectInput( $question->GetCorrect() );
        $answers = array();

        //Create an array of true and false of the current answers.
        for($i = 0; $i < $question->GetAnswersCount(); $i++)
        {
            $id = "answer" . $i;
            if($this->request->hasPost($id))
            {
                array_push($answers, $this->request->getPost($id));
            }
            else
            {
                array_push($answers, "");
            }
        }

        //Compare these witth the correct array.
        $isCorrect = true;
        for($n = 0; $n < count($answers); $n++)
        {
            //If it contains a seperation symbol..
            if(strpos($correct[$n], "&"))
            {
                //Split into an array of answers
                $possibleAnswers = explode("&", $correct[$n]);

                //for each possible answer we check if its right, store it into an array.
                $result = array();
                foreach($possibleAnswers as $answer)
                {
                    array_push($result, strtolower(trim($answer)) == strtolower(trim($answers[$n])));
                }

                //If all the results are false, we can confirm that its incorrect.
                if(!in_array(true, $result))
                {
                    $isCorrect = false;
                }
            }
            else
            {
                //Compare the two string with eachother, if false the answer was incorrect.
                if(strtolower(trim($correct[$n])) != strtolower(trim($answers[$n])))
                {
                    $isCorrect = false;
                }
            }
        }

        return $this->StoreResult($isCorrect, $answers);
    }

    private function StoreResult($correct, $answers)
    {
        $question = $this->questionmanager->CurrentQuestion();

        if($correct)
        {
            $question->SetLastAnswer( $answers );
            $question->SetResult( QuestionContainer::QUESTION_CORRECT );

            $result =  $this->questionmanager->NextQuestion();
            if($result)
            {
                $this->response->redirect("/vraagtoets");
            }else
            {
                $this->response->redirect("/vraagtoets/end");
            }


            return true;
        }
        else
        {
            $question->SetLastAnswer( $answers );
            $question->SetResult( QuestionContainer::QUESTION_WRONG );

            $result =  $this->questionmanager->NextQuestion();
            if($result)
            {
                $this->response->redirect("/vraagtoets");
            }
            else
            {
                $this->response->redirect("/vraagtoets/end");
            }

            return false;
        }
    }
}