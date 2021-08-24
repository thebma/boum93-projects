<?php

class QuestionContainer extends Phalcon\Mvc\User\Component
{
    //TODO: Intergrate the DatabaseAdapter, should return php arrays not JSON string.
    //TODO: Figure out which functions return json Kappa

    //Private variables that hold data, these are accesed by the property functions.
    private $id;
    private $json_answer;
    private $type;
    private $question;
    private $answers;
    private $answers_count;
    private $correct;
    private $image = "0.jpg";
    private $instruction = "";
    private $feedback;
    private $result;
    private $lastAnswer = -1;

    //Constants that states in what state the question container is.
    const QUESTION_UNASWERED = 0;
    const QUESTION_CORRECT = 1;
    const QUESTION_WRONG = 2;
    const QUESTION_SKIPPED = 3;

    // Property that holds the ID of the question
    public function SetId($id) { $this->id = $id; }
    public function GetId() { return $this->id; }

    //Required for reconstructing the old answer array after an answer was given
    //Otherwise it would be a javascript implementation.
    public function SetJsonAnswer($json) { $this->json_answer = $json; }
    public function GetJsonAnswer() { return $this->json_answer; }

    //Property holds and integer that indicates the type of question(single: 1, multiple: 2, input: 3).
    public function SetType($type) { $this->type = $type; }
    public function GetType() { return $this->type; }

    //Property that hold the string of the question that is asked.
    public function SetQuestion($question) { $this->question = $question; }
    public function GetQuestion() { return $this->question; }

    //Property that holds the image path, name and extension of the question.
    public function SetImage($image) { $this->image = $image; }
    public function GetImage() { return $this->image; }

    //Property that hold the instruction string.
    public function SetInstruction($instruction) { $this->instruction = $instruction; }
    public function GetInstruction() { return $this->instruction; }

    // Property that hold the HTML of the answers.
    public function SetAnswers($answers) { $this->answers = $answers; }
    public function GetAnswers() { return $this->answers; }

    // Property tells the system how many answers there can be given.
    public function SetAnswersCount($answers_count) { $this->answers_count = $answers_count; }
    public function GetAnswersCount() { return $this->answers_count; }

    // Property that tells the system which answers are correct.
    public function SetCorrect($correct) { $this->correct = $correct; }
    public function GetCorrect() { return $this->correct; }

    // Property that holds the HTML of the feedback.
    public function SetFeedback($feedback) { $this->feedback = $feedback; }
    public function GetFeedback() { return $this->feedback; }

    // Property for the result, uses the constants in this class.
    public function SetResult($result){
        //Clamp the result value, avoid unknown states
        if( $result >= 0 && $result <= 3)
        {
            $this->result = $result;
        }
    }
    public function GetResult() { return $this->result; }

    // Property for returning the last given answer (single: integer, multiple: array of integers, input: array of strings).
    public function SetLastAnswer($answer) { $this->lastAnswer = $answer; }
    public function GetLastAnswer() { return $this->lastAnswer; }
}
