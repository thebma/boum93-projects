<?php
class ToetsIndex extends Phalcon\Mvc\User\Component
{
    public function DisplayTable($data)
    {
        return "<table class='table table-striped'><tr>
                <th>Toetsnaam</th>
                <th>Categorie</th>
                <th>Aangemaakt</th>
                <th>Type</th>
                <th>Vragen</th>
                <th>Configuratie</th>
                <th>Verwijder</th></tr>". $data ."
            </table>";
    }

    public function DisplayRow($data)
    {
        return "<td>" . $data->titel . "</td>
                <td>" . $this->GetCategorieById($data->categorie) . "</td>
                <td>" . $data->created . "</td>
                <td>" . $this->GetType($data->type) . "</td>
                <td><a href='/editor/questions?id=" . $data->id . "'><div class='linkedit'><i class='fa fa-pencil'></i></div></a></td>
                <td><a href='/editor/config?id=" . $data->id . "'><div class='linkedit'><i class='fa fa-file-o'></i></div></a></td>
                <td><a href='/editor/delete?id=" . $data->id . "'><div class='linkedit'><i class='fa fa-trash-o'></i></div></a></td></tr>";
    }

    public function GetType($typeid)
    {
        switch($typeid)
        {
            case 1:
                return "Oefentoets";
            case 2:
                return "Oefenexamen";
            default:
                return "Oefentoets";
        }
    }

    public function GetCategorieById($id)
    {
        $categorie = new Categorie();
        $result = $categorie->findFirst("id=$id");

        return $result->naam;

    }
}

?>
