<?php

include_once "QuestionContainer.php";
include_once "QuestionElements.php";

class QuestionCreator extends Phalcon\Mvc\User\Component
{
    private $count;

    /**
     * @var $elements QuestionElements
     */
    private $elements;

    public function __construct()
    {
        $this->elements = new QuestionElements();
    }

    public function Create($question, $type)
    {
        $questionContainer = new QuestionContainer();
        $questionContainer->SetId($question->id);
        $questionContainer->SetJsonAnswer($question->antwoord);
        $questionContainer->SetType( $question->type );
        $questionContainer->SetQuestion($question->vraag);
        $questionContainer->SetImage($question->vraag_image);
        $questionContainer->SetInstruction($question->instructies);
        $questionContainer->SetAnswers( $this->CreateAnswers($question->antwoord, $question->type) );
        $questionContainer->SetAnswersCount( $this->count );
        $questionContainer->SetCorrect( $question->correct );

        $feedback = "";
        if( $type == "1")
        {
            $feedback .= $this->GenerateFeedbacks( $question->feedbacktext, $question->feedbackimage, $question->feedbackimagetext);
        }
        else if($type == "2")
        {
            $feedback .= $this->GenerateFeedbacks( $question->feedbacktext, $question->feedbackimage, $question->feedbackimagetext, true);
        }
        else
        {
            $err = new Error("unknown_config_type", "Onbekende type is gevonden, feedbacks konden niet gegenereerd worden.");
            $feedback = $err->Render();
        }

        $questionContainer->SetFeedback( $feedback );

        return $questionContainer;
    }

    public function CreateArray($question, $amount, $type)
    {
        $array = array();
        $array_ids = array();
        $tries = 0;

        //Generate random ids to fetch, avoid duplicates.
        while(count($array_ids) < 25)
        {
            list($usec, $sec) = explode(' ', microtime());
            $seed = (float) $sec + ((float) $usec * 100000);
            srand($seed);

            $rand_id = rand(0, (count($question) - 1));
            if(!in_array($rand_id, $array_ids))
            {
                array_push($array_ids, $rand_id);
                shuffle($array_ids);
            }

            if($tries > 500)
            {
                $this->response->redirect("/?error=rng_overflow");
                break;
            }

            $tries++;
        }

        //Fetch questions using this id
        for($i = 0; $i < $amount; $i++)
        {
            $container = $this->Create( $question[ $array_ids[$i] ], $type );
            array_push($array, $container);
        }

        return $array;
    }

    //Convert the json to html.
    public function CreateAnswers($answers, $type, $correct = "")
    {
        $questionelements = $this->elements;

        $json_array = json_decode($answers, true);

        $html = '';
        $elements = array();

        foreach ($json_array as $key => $question)
        {
            switch($type)
            {
                case 1:
                    $html = $questionelements->CreateSingleAnswer($key, $question, $this->type, $this->IsChecked($key, $correct));
                    break;
                case 2:
                    $html = $questionelements->CreateMultipleAnswer($key, $question, $this->type,  $this->IsChecked($key, $correct));
                    break;
                case 3:
                    $html = $questionelements->CreateInputAnswer($key, $question, $key, $this->IsChecked($key, $correct, $type));
                    break;
            }

            array_push($elements, $html);
        }

        $this->count = count($elements);

        shuffle($elements);

        $allhtml = '';
        foreach ($elements as $element)
        {
            $allhtml .= $element;
        }

        return $allhtml;
    }

    private function IsChecked($key, $correct, $type)
    {
        switch($type)
        {
            case 1:
                if($correct != "")
                {
                    if ($correct == $key) {
                        return true;
                    }
                }
                return false;
            case 2:
                if($correct != null)
                {
                    return $correct[$key];
                }
                return false;
            case 3:
                return $correct[$key];
        }

        return false;
    }

    //Create the feedback elements.
    private function GenerateFeedbacks($feedbacktext, $feedbackimage, $feedbackimagetext, $dummy=false)
    {
        $html = '';
        $questionelements = $this->elements;

        $array_text = json_decode($feedbacktext, true);
        $array_image = json_decode($feedbackimage, true);
        $array_imagetext = json_decode($feedbackimagetext, true);

        $feedbackCollection = array();

        for ($i = 0; $i < count($array_text); $i++)
        {
            $feedbackCollection[$i]["text"] = $array_text[$i];
            $feedbackCollection[$i]["image"] = $array_image[$i];
            $feedbackCollection[$i]["imagetext"] = $array_imagetext[$i];
        }

        $id = 1;
        $toetsid = $this->session->get("toetsid");
        foreach ($feedbackCollection as $collection)
        {
            if($dummy == true)
            {
                $html .= $questionelements->CreateEmptyFeedback($id);
            }
            else
            {
                if ($collection["text"] != "" || $collection["imagetext"] != "" || $collection["image"] != "0.jpg")
                {
                    $html .= $questionelements->CreateFeedback($id, $toetsid, $collection["text"], $collection["image"], $collection["imagetext"]);
                }
                else
                {
                    $html .= $questionelements->CreateEmptyFeedback($id);
                }
            }

            $id++;
        }

        return $html;
    }

    public function GetModals()
    {
        return json_encode( $this->elements->modals);
    }

}