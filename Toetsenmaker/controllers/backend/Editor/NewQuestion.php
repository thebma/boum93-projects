<?php

class NewQuestion extends Phalcon\Mvc\User\Component
{
    public function ProcessQuestion()
    {
        return "<label class='edit-header'>Gestelde vraag:</label><div>" . $this->tag->textField(array("vraag", "class" => "form-control", "id" => "vraag", "style" => "max-width:100%;")) . "</div>";
    }

    public function ProcessAmount($toetsid)
    {
        $url = "?id=" . $toetsid;

        $html = "";
        $html .= "<label class='edit-header'>Kies het aantal vragen/antwoorden u wilt <span class=\"smallltext\">( klik op \"Pas formulier\" om de wijziging door te voeren! ) </span></label><div>" . $this->tag->numericField(array("vraag", "class" => "form-control", "id" => "aantalvragen", "style" => "max-width:81%; float:left;")) . "</div>";
        $html .= "<button id='adjustbutton' type='button' style='display: inline-block;'onclick=\"AdjustForm('" .$url. "')\">Pas formulier aan</button><br/><br/><br/>";

        return $html;
    }

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

    public function ProcessInstructions()
    {
        return '<label class="edit-header">Instructies:</label>' .  $this->tag->textField(array("instructie", "class" => "form-control", "placeholder" => "Instructies", "id" => "instruct"));
    }

    public function ProcessAnswers($aantal)
    {
        $html = '<label class="edit-header">Mogelijke antwoorden:</label>';
        for($i = 0; $i < $aantal; $i++)
        {
            $id = $i + 1;
            $html .= "<input class='form-control cacheable' placeholder='antwoord " . $id . "' name='antwoord ". $id . "' id='antwoord" . $id . "'>";
        }

        $html .= "<div id='input'><a onclick=\"AddInput();\"><i class='fa fa-keyboard-o'></i>&nbsp;Voeg invulveld toe</a> <span class=\"smalltext\">( de ingevoegde text zal vervangen worden voor een invul veld )</span></div><br/><br/>";

        return $html;
    }

    public function ProcessCorrectAnswers($aantal)
    {
        $html = '<label>Correcte antwoord(en):</label>';
        for($i = 0; $i < $aantal; $i++)
        {
            $id = $i + 1;
            $html .= "<div class='radio type1'><label> <input type='radio' name='correct' value='" . $id . "' class='radio'>Antwoord " . $id . "</label></div>";
            $html .= "<div class='checkbox type2'><label> <input type='checkbox' name='correct" . $id . "' value='" . $id . "' class='checkbox'>Antwoord " . $id . "</label></div>";
            $html .= $this->tag->textField(array("correct" . $id . "", "class" => "form-control cacheable type3", "placeholder" => "Correcte antwoord", "style" => "", "value" => ""));
        }

        $html .= "<div id='seperate'><a onclick=\"AddSeperation();\"><i class='fa fa-scissors'></i>&nbsp;Voeg scheidingsteken toe</a> <span class=\"smalltext\">( Scheidings teken zorgt voor meerdere correcte antwoorden voor één vraag. )</span></div>";

        return $html;
    }

    public function ProcessFeedbackAnswers($aantal)
    {
        $html = '<label class="edit-header">Antwoorden feedback</label>';
        for($i = 0; $i < $aantal; $i++)
        {
            $id = $i + 1;
            $html .= $this->tag->textField(array("feedback " . $id . "", "class" => "form-control", "placeholder" => "Feedback  " . $id . ""));
        }

        return $html;
    }

    public function ProcessFeedbackImage($aantal, $toetsid)
    {
        $html = '<label class="edit-header">Feedback onder plaatjes:</label>';
        for($i = 0; $i < $aantal; $i++)
        {
            $id = $i + 1;
            $html .= "<div class=\"feedbackdiv\">";
            $html .= $this->tag->textField(array("imgfeedback" . $id. "", "class" => "form-control", "placeholder" => "Feedback voor dit plaatje...", "style" => ""));
            $html .= '<label class="upload-label">Selecteer een plaatje voor de feedback:</label>' . $this->tag->fileField('feedback' . $id) . "</div><br/>";
            $html .= '<img onclick="ZoomImage(this)" class="img-feedback-preview" src="../../../public/img/toetsen/' . $toetsid . '/0.jpg">';
        }

        return $html;
    }

    public function ProcessFormHeader($tid, $vid)
    {
        return  $this->tag->form(array("/editor/save_quest?id=".$tid."&vraagid=".$vid."", "method" => "post", "id" => "newquestionForm", "name" => "newquestionForm", "enctype" => "multipart/form-data"));
    }

    public function ProcessSubmitButton()
    {
        return $this->tag->submitButton(array(
            'class' => "btn btn-primary",
            'form' => 'newquestionForm',
            'style' => 'margin-top: 30px; width: 100%; margin-left: 5%;',
            'value' => 'Maak vraag aan'
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
}

?>