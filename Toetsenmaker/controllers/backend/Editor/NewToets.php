<?php

class NewToets extends Phalcon\Mvc\User\Component
{
    public function ProcessFormHeader()
    {
        return  $this->tag->form(array("/editor/newtoets", "method" => "post", "id" => "newtoetsForm", "name" => "newtoetsForm", "enctype" => "multipart/form-data"));
    }

    public function ProcessSubmitButton()
    {
        return $this->tag->submitButton(array(
            'class' => "btn btn-primary",
            'form' => 'newtoetsForm',
            'style' => 'margin-top: 30px; width: 100%; margin-left: 5%;',
            'value' => 'Maak toets aan'
        ));
    }

    public function ProcessFormEnd()
    {
        return "</form>";
    }

    public function ProcessTitel()
    {
        return "<label class='edit-header'>Toetsnaam:</label><div>" . $this->tag->textField(array("titel", "class" => "form-control", "id" => "vraag", "style" => "max-width:100%;")) . "</div>";
    }

    public function ProcessCategorie()
    {
        $catagorieen = Categorie::find();

        $naam = '<div class="categorie"><label class="edit-header">Categorie:</label><select name="catagorie" class="form-control">';
        foreach($catagorieen as $catagorie)
        {
            $naam .= "<option value='". $catagorie->naam ."'>" . $catagorie->naam . "</option>";
        }
        $naam .= "<select></div>";

        $naam .= "<div class='categorie'><label class='edit-header'>Nieuw Categorie:</label>" . $this->tag->textField(array("new_categorie", "class" => "form-control", "id" => "vraag", "style" => "max-width:100%;")) . "</div>";

        return $naam;
    }

    public function ProcessType()
    {
        $types = array(
            'Oefentoets',
            'Oefenexamen'
        );

        $html = '<label class="edit-header">Type:</label><select name="type" class="form-control">';

        for($i = 0; $i < count($types); $i++)
        {
            $html .= "<option value=".($i+1).">" . $types[$i] . "</option>";
        }

        return $html;
    }

    public function ProcessEditor()
    {
        return Phalcon\Tag::hiddenField(array("config_id", "value" => "")) . "
        <br>
        <label for='starttext'>Introductie Tekst:</label>
            " . Phalcon\tag::textArea(array("starttext","class" => "form-control" , "rows" => "10", "value"=>"", "id" => "replace_editor2")) .
        "</textarea>

         <script>
            CKEDITOR.replace( 'replace_editor2' );
        </script>";
    }

    public function ProcessBackgroundImage()
    {
        $html = "<div class=\"feedbackdiv\">";
        $html .= '<label class="upload-label">Selecteer een plaatje voor de achtergrond:</label>' . $this->tag->fileField('feedback') . "</div><br/>";
        return $html;
    }

    public function ProcessAantalvragen()
    {
        return "<br/><br/>
                <label class='edit-header' style='width: 100%;'' for='aantalvragen'>Aantal vragen:</label>
                    " . Phalcon\tag::numericfield(array("aantalvragen", "min" => "4", "max" => "1000", "value" => "", "class" => "form-control")). "
                </label>";
    }

    public function ProcessTime($oldtijd)
    {
        $tijd = explode(":", $oldtijd);

        $html = "<div class='timefield'>";
        $html .= "<label for='hour'> Uren: </label>";
        $html .=  Phalcon\tag::numericfield(array("hour", "min" => "0", "max" => "24", "value" => $tijd[0], "class" => "form-control"));
        $html .= "</div>";

        $html .= "<div class='timefield'>";
        $html .= "<label for='min'> Minuten: </label>";
        $html .=  Phalcon\tag::numericfield(array("min", "min" => "0", "max" => "60", "value" => $tijd[1], "class" => "form-control"));
        $html .= "</div>";

        $html .= "<div class='timefield'>";
        $html .= "<label for='sec'> Seconden: </label>";
        $html .=  Phalcon\tag::numericfield(array("sec", "min" => "0", "max" => "60", "value" => $tijd[2], "class" => "form-control"));
        $html .= "</div>";
        $html .= "<br/><br/><br/>";

        return $html;
    }


}

?>