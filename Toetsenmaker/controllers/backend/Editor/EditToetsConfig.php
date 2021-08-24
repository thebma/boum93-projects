<?php

class EditToetsConfig extends Phalcon\Mvc\User\Component
{
    public function ProcessTitle($row)
    {
        return "<label for='titel'>Toetsnaam:</label>" . Phalcon\Tag::textField(array("titel", "class" => "form-control", "value" => $row->titel));

    }

    public function ProcessFormHeader($id)
    {
        return  $this->tag->form(array("/editor/saveconfig?id=". $id ."", "method" => "post", "id" => "editconfigForm", "name" => "editconfigForm", "enctype" => "multipart/form-data"));
    }

    public function ProcessEditor($row)
    {
        return Phalcon\Tag::hiddenField(array("config_id", "value" => $row->id)) . "
        <br>
        <label for='starttext'>Introductie Tekst:</label>
            " . Phalcon\tag::textArea(array("starttext","class" => "form-control" , "rows" => "10", "value"=>$row->starttext, "id" => "replace_editor")) .
        "</textarea>

         <script>
            CKEDITOR.replace( 'replace_editor' );
        </script>";
    }

    public function ProcessAantalvragen($row)
    {
        return "<br/><br/>
                <label class='edit-header' style='width: 100%;'' for='aantalvragen'>Aantal vragen:</label>
                    " . Phalcon\tag::numericfield(array("aantalvragen", "min" => "4", "max" => "1000", "value" => $row->aantalvragen, "class" => "form-control")). "
                </label>";
    }

    public function ProcessSubmit()
    {
        return "<br><input style='width: 100%;' type='submit' class='btn btn-primary' value='Pas configuratie aan'>";
    }

    public function ProcessBackgroundImage($toetsid, $img)
    {
        $html = "<div class=\"feedbackdiv\">";
        $html .= '<label class="upload-label">Selecteer een plaatje voor de achtergrond:</label>' . $this->tag->fileField('feedback') . "</div><br/>";
        $html .= '<img onclick="ZoomImage(this)" class="img-feedback-preview" src="../../../public/img/toetsen/' . $toetsid . '/'.$img.'">';

        return $html;
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

    public function ProcessCategorie($categorieid)
    {
        $catagorieen = Categorie::find();

        $naam = '<div class="categorie"><label class="edit-header">Categorie:</label><select name="catagorie" class="form-control">';
        foreach($catagorieen as $catagorie) {
            if ($categorieid == $catagorie->id)
            {
                $naam .= "<option selected value='". $catagorie->naam ."'>" . $catagorie->naam . "</option>";
            }
            else
            {
                $naam .= "<option value='". $catagorie->naam ."'>" . $catagorie->naam . "</option>";

            }
        }
        $naam .= "<select></div>";

        $naam .= "<div class='categorie'><label class='edit-header'>Nieuw Categorie:</label>" . $this->tag->textField(array("new_categorie", "class" => "form-control", "id" => "vraag", "style" => "max-width:100%;")) . "</div>";

        return $naam;
    }

    public function ProcessType($typeid)
    {
        $types = array(
            'Oefentoets',
            'Oefenexamen'
        );

        $html = '<label class="edit-header">Type:</label><select name="type" class="form-control">';

        for($i = 0; $i < count($types); $i++) {
            if ($types[ ( $typeid - 1 ) ] == $types[$i])
            {
                $html .= "<option selected value=" . ($i + 1) . ">" . $types[$i] . "</option>";
            }
            else
            {
                $html .= "<option value=" . ($i + 1) . ">" . $types[$i] . "</option>";
            }
        }

        return $html;
    }
}