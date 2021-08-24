<?php

class EditQuestion extends Phalcon\Mvc\User\Component
{
    public $aantal;

    /*
     * Set the amount of questions to be displayed
     */
    public function __construct($aantal)
    {
        $this->aantal = $aantal;
    }

    /*
     * Add HTML element for the question ( text field )
     */
    public function ProcessQuestion($question)
    {
        return "<label class='edit-header'>Gestelde vraag:</label><div>" . $this->tag->textField(array("vraag", "class" => "form-control", "id" => "vraag", "style" => "max-width:100%;", "value" => $question)) . "</div>";
    }

    /*
     * Make a select element and process the array of different types.
     */
    public function ProcessQuestionType($selected)
    {
        $arrayType = array(
            '1' => "Enkel antwoord",
            '2' => "Meerdere antwoorden",
            '3' => "Open vraag"
        );

        $html = " <label class='edit-header'>Vraag type:</label><select onchange='HandleSelect(this)' id='select_type' name='select_type' class='form-control'><option value=''>Selecteer een vraag type</option>";
        foreach($arrayType as $id => $name)
        {
            if ($selected == $id)
            {
                $html .= "<option selected='selected' value='" . $id . "'> " . $name . " </option>";
            }
            else
            {
                $html .= "<option value='" . $id . "'> " . $name . " </option>";
            }
        }
        $html .= "</select>";

        return $html;
    }

    /*
     * Add an text field for the instruction.
     */
    public function ProcessInstructions($instruction)
    {
        return '<label class="edit-header">Instructies:</label>' .  $this->tag->textField(array("instructie", "class" => "form-control", "placeholder" => "Instructies", "id" => "instruct", "value" => $instruction));
    }

     /*
     * Display all the possible answers.
     */
    public function ProcessAnswers($anwsers, $type)
    {
        $html = '<label class="edit-header">Mogelijke antwoorden:</label>';
        for($i = 0; $i < $this->aantal; $i++)
        {
            $id = $i + 1;
            $html .= "<input class='form-control cacheable' placeholder='antwoord " . $id . "' name='antwoord ". $id . "' id='antwoord" . $id . "' value='" . $anwsers[$i] . "'>";
        }

        if($type == 3)
        {
            $html .= "<a onclick=\"AddInput();\"><i class='fa fa-keyboard-o'></i>&nbsp;Voeg invulveld toe</a> <span class=\"smalltext\">( de ingevoegde text zal vervangen worden voor een invul veld )</span><br/><br/>";
        }

        return $html;
    }

    /*
     * Create correct answers html.
     */
    public function ProcessCorrectAnswers($answers, $type)
    {
        $html = '<label class="edit-header">Correcte antwoord(en):</label>';
        for($i = 0; $i < $this->aantal; $i++)
        {
            $id = $i + 1;

            //Show radio button, if correct show as checked else not check it.
            if($type == 1 && $answers[$i] == 1)
            {
                $html .= "<div class='radio type1'><label> <input checked type='radio' name='correct_radio' value='" . $id . "' class='radio'>Antwoord " . $id . "</label></div>";
            }else
            {
                $html .= "<div class='radio type1'><label> <input type='radio' name='correct_radio' value='" . $id . "' class='radio'>Antwoord " . $id . "</label></div>";
            }

            //Show checkbox, if correct show as checked else not check it.
            if($type == 2 && $answers[$i] == 1)
            {
                $html .= "<div class='checkbox type2'><label> <input checked type='checkbox' name='correct_check_" . $id . "' value='" . $id . "' class='checkbox'>Antwoord " . $id . "</label></div>";
            }
            else
            {
                $html .= "<div class='checkbox type2'><label> <input type='checkbox' name='correct_check_" . $id . "' value='" . $id . "' class='checkbox'>Antwoord " . $id . "</label></div>";
            }

            //Show textfield, if type 3 give the textfield a value, else dont.
            if($type == 3)
            {
                $html .= $this->tag->textField(array("correct_text_" . $id . "", "class" => "form-control cacheable type3", "placeholder" => "Correcte antwoord", "style" => "", "value" => $answers[$i]));

            }
            else
            {
                $html .= $this->tag->textField(array("correct_text_" . $id . "", "class" => "form-control cacheable type3", "placeholder" => "Correcte antwoord", "style" => "", "value" => ""));

            }
        }

        //Button for seperating anwsers for open questions.
        $html .= "<div id='seperate'><a onclick=\"AddSeperation();\"><i class='fa fa-scissors'></i>&nbsp;Voeg scheidingsteken toe</a> <span class=\"smalltext\">( Scheidings teken zorgt voor meerdere correcte antwoorden voor één vraag. )</span></div>";

        return $html;
    }

    /*
     * Create textboxes for the feedback that goes along with the answers.
     */
    public function ProcessFeedbackAnswers($answers)
    {
        $html = '<label class="edit-header">Antwoorden feedback</label>';
        for($i = 0; $i < $this->aantal; $i++)
        {
            $id = $i + 1;
            $html .= $this->tag->textField(array("feedback " . $id . "", "class" => "form-control", "placeholder" => "Feedback  " . $id . "", "value" => $answers[$i]));
        }

        return $html;
    }

    /*
     * Create feedback textfields, displayed under the image.
     */
    public function ProcessFeedbackImage($image, $imagetext, $toetsid)
    {
        $html = '<label class="edit-header">Feedback onder plaatjes:</label>';
        for($i = 0; $i < $this->aantal; $i++)
        {
            $id = $i + 1;
            $html .= "<div class=\"feedbackdiv\">";
            $html .= $this->tag->textField(array("imgfeedback" . $id. "", "class" => "form-control", "placeholder" => "Feedback voor dit plaatje...", "style" => "", "value" => $imagetext[$i]));
            $html .= '<label class="upload-label">Selecteer een plaatje voor de feedback:</label>' . $this->tag->fileField('feedback' . $id) . "</div><br/>";
            $html .= '<img onclick="ZoomImage(this)" class="img-feedback-preview" src="../../../public/img/toetsen/' . $toetsid . '/' . $image[$i] . '">';
        }

        return $html;
    }

    /*
     * Create form header
     */
    public function ProcessFormHeader($tid, $vid)
    {
        return  $this->tag->form(array("/editor/save_quest?id=".$tid."&vraagid=".$vid."", "method" => "post", "id" => "editquestionForm", "name" => "editquestionForm", "enctype" => "multipart/form-data"));
    }

    public function ProcessSubmitButton()
    {
        return $this->tag->submitButton(array(
            'class' => "btn btn-primary",
            'form' => 'editquestionForm',
            'style' => 'margin-top: 30px; width: 100%; margin-left: 5%;',
            'value' => 'Pas de vraag aan'
        ));
    }


    public function ProcessFormEnd()
    {
        return "</form>";
    }

    public function ProcessImage($toetsid, $image)
    {
        $html = '<label class="edit-header">Afbeelding bij de vraag:</label><br/>';
        $html .= '<label class="upload-label">Selecteer een plaatje voor de vraag:</label>' . $this->tag->fileField('image') . "<br/>";
        $html .= '<img onclick="ZoomImage(this)" class="img-preview" src="../../../public/img/toetsen/' . $toetsid . '/' . $image . '">';

        return $html;
    }

    public function ProcessAmount($toetsid, $vraagid)
    {
        $url = "?id=" . $toetsid . "&vraagid=" . $vraagid;

        $html = "";
        $html .= "<label class='edit-header'>Kies het aantal vragen/antwoorden u wilt <span class=\"smallltext\">( klik op \"Pas formulier\" om de wijziging door te voeren! ) </span></label><div>" . $this->tag->numericField(array("vraag", "class" => "form-control", "id" => "aantalvragen", "style" => "max-width:81%; float:left;", "value" => $this->aantal)) . "</div>";
        $html .= "<button id='adjustbutton' type='button' style='display: inline-block;'onclick=\"AdjustForm('" .$url. "')\">Pas formulier aan</button><br/><br/><br/>";

        return $html;
    }
}

?>