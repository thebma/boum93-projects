<?php

include_once __DIR__ . "/Toets/ScoreManager.php";
include_once __DIR__ . "/Toets/QuestionContainer.php";
include_once __DIR__ . "/Toets/QuestionSessiondata.php";
include_once __DIR__ . "/Toets/QuestionManager.php";
include_once __DIR__ . "/Toets/QuestionCheck.php";
include_once __DIR__ . "/Toets/QuestionCreator.php";
include_once __DIR__ . "/Toets/TimeManager.php";

class VraagtoetsController extends \Phalcon\Mvc\Controller
{
    private $toetsid = null;
    private $toetconfigModel = null;

    /**
     * @var $sessiondata QuestionSessiondata
     */
    private $sessiondata = null;

    /**
     * @var $questionmanager QuestionManager
     */
    private $questionmanager = null;

    /**
     * @var $scoremanager ScoreManager
     */
    private $scoresmanager = null;

    /***
     * @var $timemanager TimeManager
     */
    private $timemanager = null;


    private $configType = "1";

    public function indexAction()
    {
        //Setup the base page, plus some additional css/js
        $base = new BasicPage(1);
        $this->assets->addCss('css/starttoets.css')
                     ->addJs('js/toets/toetstimer.js')
                     ->addJS("js/toets/toetsfeedback.js");

        //Create a new session caching class.
        $creator = new QuestionCreator($this->configType);
        $this->sessiondata = new QuestionSessiondata();
        $this->toetsid = $this->sessiondata->GetToetsid();

        //Get the config model
        $this->toetconfigModel = Toetsconfig::findFirst($this->toetsid);
        $this->configType = $this->toetconfigModel->type;

        //See if the question session container holds a reference to the QuestionManager.
        if(!$this->sessiondata->HasQuestionManager())
        {
            $this->questionmanager = new QuestionManager();
            $this->sessiondata->SetQuestionManager($this->questionmanager);
        }
        else
        {
            $this->questionmanager = $this->sessiondata->GetQuestionManager();
        }

        //See if the question session container holds a reference to the ScoreManager.
        if(!$this->sessiondata->HasScoresManager())
        {
            $this->scoresmanager = new ScoreManager($this->questionmanager);
            $this->sessiondata->SetScoresManager($this->scoresmanager);
        }
        else
        {
            $this->scoresmanager = $this->sessiondata->GetScoresManager();
        }

        //Check if we have a registered time manager in the session data class.
        if(!$this->sessiondata->HasTimeManager())
        {
            $this->timemanager = new TimeManager();
            $this->timemanager->Intialize($this->toetconfigModel->tijd);
            $this->sessiondata->SetTimeManager($this->timemanager);
        }
        else
        {
            $this->timemanager = $this->sessiondata->GetTimeManager();
        }

        //Check if we have all the managers needed.
        if($this->questionmanager != null)
        {
            $this->questionmanager->Initialize($this->toetsid, $this->toetconfigModel, $this->configType);
            $question = $this->questionmanager->CurrentQuestion();

            //Some sanity checking to prevent unexpected output
            if($question != null && $this->toetsid != null && $this->toetconfigModel != null)
            {
                //Assign views
                $this->view->id = $this->toetsid;
                $this->view->skipped = 1;

                // Question views
                $this->view->question = $question->GetQuestion();
                $this->view->image = $question->GetImage();
                $this->view->instruction = $question->GetInstruction();
                $this->view->feedback = $question->GetFeedback();

                //Generate a answers based upon previous answers (checked or not checked.
                if($question->GetResult() == QuestionContainer::QUESTION_UNASWERED && $question->GetLastAnswer() != null)
                {
                    $this->view->answers = $question->GetAnswers();
                }
                else
                {
                    $this->view->answers = $creator->CreateAnswers( $question->GetJsonAnswer(), $question->GetType(), $question->GetLastAnswer() );
                }

                //Time, score and question data views
                $this->view->time = $this->timemanager->GetTimeRemaining();
                $this->view->correct = $this->scoresmanager->GetCorrect();
                $this->view->wrong = $this->scoresmanager->GetWrong();
                $this->view->background = $this->toetconfigModel->bgimage;
                $this->view->titel = $this->toetconfigModel->titel;
                $this->view->countquestion = "<p id='questioncount'>" . ($this->questionmanager->GetIndex() + 1) . "/" . $this->toetconfigModel->aantalvragen . "<span id='questionsskipped'>" . $this->scoresmanager->GetSkipped() . "</span></p>";

                //Buttons
                $this->view->nextbutton = $this->questionmanager->GetNextButton();
                $this->view->skipbutton = $this->questionmanager->GetSkipButton();
                $this->view->previousbutton = $this->questionmanager->GetPreviousButton();
                $this->view->endbutton = $this->questionmanager->GetEndButton();

                //Debug
                $this->view->modals = "";
                $this->view->log = "";
            }
            else
            {
                //Cannot load question or database model is missing.
                $this->TryDestroy();
                $this->response->redirect("/?error=c_vt_index_1");
            }
        }
        else
        {
            //Question manager could not be created or is null.
            $this->TryDestroy();
            $this->response->redirect("/?error=c_vt_index_2");
        }
    }

    public function processAction()
    {
        /** @var $questionmanager QuestionManager */
        $questionmanager = $this->session->get("questionmanager");

        /** @var $scoremanager ScoreManager */
        $action = strtolower($this->request->getPost("action"));

        if ($questionmanager != null)
        {
            /** @var $question QuestionContainer */
            $question = $questionmanager->CurrentQuestion();

            if($question != null)
            {
                //Handle next question behaviour.
                if ($action == "volgende")
                {
                    $type = $question->GetType();
                    $checker = new QuestionCheck();
                    $checker->Check($questionmanager, $type);
                }

                //Handle previous question behaviour;
                if ($action == "vorige")
                {
                    $questionmanager->PreviousQuestion();
                    $this->response->redirect("/vraagtoets");
                }

                //Handle skip behaviour.
                if ($action == "overslaan")
                {
                    $question->SetResult(QuestionContainer::QUESTION_SKIPPED);

                    $result = $questionmanager->NextQuestion();
                    if($result)
                    {
                        $this->response->redirect("/vraagtoets");
                    }else
                    {
                        $this->response->redirect("/vraagtoets/end");
                    }
                }
             }
          }
        else
        {
            $this->TryDestroy();
            $this->response->redirect("/?error=c_vt_process_1");
        }
    }

    //Reset all the sessions.
    public function resetAction()
    {
        $toetsid = $this->session->get("toetsid");

        if(!$toetsid)
        {
            $this->response->redirect("/?error=c_vt_reset_1");
        }

        $this->TryDestroy();

        $this->response->redirect("/starttoets?toetsid=" . $toetsid);
    }

    public function endAction()
    {
        $base = new BasicPage(1);
        $this->assets->addCss('/css/starttoets.css');

        /** @var $scoremanager ScoreManager */
        $scoremanager = $this->session->get("scoresmanager");

        /** @var $questionmanager QuestionManager */
        $questionmanager = $this->session->get("questionmanager");

        /** @var $timemanager TimeManager */
        $timemanager = $this->session->get("timemanager");

        $questionArray = array();

        /** @var $question QuestionContainer */
        foreach($questionmanager->GetQuestionArray() as $question)
        {
            array_push($questionArray, $this->SerializeQuestion($question));
        }

        $toetsid = $this->session->get("toetsid");
        $toetsResultaat = new Toetsresultaten();
        $toetsResultaat->leerling_id = $this->session->get("auth")["id"];
        $toetsResultaat->toetsen_id = $toetsid;
        $toetsResultaat->resultaat = json_encode($questionArray);
        $toetsResultaat->tijd_start = $timemanager->GetStartTime();
        $toetsResultaat->tijd_stop = $timemanager->GetEndTime();
        $toetsResultaat->correct = $scoremanager->GetCorrect();
        $toetsResultaat->fout = $scoremanager->GetWrong();

        if($toetsResultaat->save() == false)
        {
            $this->response->redirect("/?error=c_vt_end_3");
        }


        if(!$toetsid)
        {
            $this->response->redirect("/?error=c_vt_end_1");
        }

        if($scoremanager != null && $toetsid != null)
        {
            $model = Toetsconfig::findFirst($toetsid);

            $this->view->id = $toetsid;
            $this->view->background = $model->bgimage;

            $this->view->correct = $scoremanager->GetCorrect();
            $this->view->wrong = $scoremanager->GetWrong();
            $this->view->skipped = $scoremanager->GetSkipped();
        }
        else
        {
            $this->TryDestroy();
            $this->response->redirect("/?error=c_vt_end_2");
        }
    }

    private function SerializeQuestion(QuestionContainer $container)
    {
        $serializedQuestion = array();
        $serializedQuestion["id"] = $container->GetId();
        $serializedQuestion["result"] = $container->GetResult();
        $serializedQuestion["answers"] = $container->GetLastAnswer();

        return $serializedQuestion;
    }

    //Try to destroy the current session, prevent corrupting when a manager is gone missing.
    private function TryDestroy()
    {
        if($this->session->has("questionmanager"))
        {
            $this->session->remove("questionmanager");
        }

        if($this->session->has("scoresmanager"))
        {
            $this->session->remove("scoresmanager");
        }

        if($this->session->has("timemanager"))
        {
            $this->session->remove("timemanager");
        }

        if($this->session->has("toetsid"))
        {
            $this->session->remove("toetsid");
        }
    }

    public function apiAction()
    {
        /** @var $timemanager TimeManager */
        $timemanager = $this->session->get("timemanager");

         $fetchstring = $this->request->get("data");

        switch($fetchstring)
        {
            case "timestart":
                $this->view->output = $timemanager->GetStartTime();
                break;
            case "timeend":
                $this->view->output = $timemanager->GetEndTime();
                break;
            case "timedone":
                $this->view->output = $timemanager->IsDone();
                break;
            case "timecurrent":
                $this->view->output = strtotime("now");
                break;
            case "timeall":
                $this->view->output = $timemanager->GetAllTimeAttributes();
                break;
            default:
                $this->view->output = json_encode("Unknown attribute");
                break;
        }
    }
}