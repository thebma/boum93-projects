<?php

include_once __DIR__ . "/Editor/EditQuestion.php";
include_once __DIR__ . "/Editor/EditQuestionSave.php";
include_once __DIR__ . "/Editor/NewQuestion.php";
include_once __DIR__ . "/Editor/EditToetsConfig.php";
include_once __DIR__ . "/Editor/NewToets.php";
include_once __DIR__ . "/Editor/NewToetsSave.php";
include_once __DIR__ . "/Editor/ToetsenIndex.php";

class EditorController extends \Phalcon\Mvc\Controller
{
    public function indexAction()
    {
        $base = new BasicPage(2);

        $index = new ToetsIndex();

        $userid = $base->auth['id'];

        $toetsconfig = new Toetsconfig();
        $result = $toetsconfig->find();

        $html = "";
        for($i = 0; $i < count($result); $i++)
        {
            if($result[$i]->userid == $base->auth["id"])
            {
                $html .= $index->DisplayRow($result[$i]);
            }
        }

        $this->view->toetsinfo = $index->DisplayTable($html);
    }

    public function createAction()
    {
        $base = new BasicPage(2);

        $newtoets = new NewToets();

        $this->view->formstart = $newtoets->ProcessFormHeader();
        $this->view->titel = $newtoets->ProcessTitel();
        $this->view->categorieen = $newtoets->ProcessCategorie();
        $this->view->type = $newtoets->ProcessType();
        $this->view->text = $newtoets->ProcessEditor();
        $this->view->background = $newtoets->ProcessBackgroundImage();
        $this->view->aantalvragen = $newtoets->ProcessAantalvragen();
        $this->view->tijd = $newtoets->ProcessTime("0:0:0");
        $this->view->submit = $newtoets->ProcessSubmitButton();
        $this->view->formend = $newtoets->ProcessFormEnd();

        $newtoets = null;
    }

    public function newtoetsAction()
    {
        $save = new NewToetsSave();
        $auth = $this->session->get("auth");

        $toetsid = 0;  //Remove after we remove the redundant data.
        $datetime = date( 'Y-m-d H:i:s');
        $text = $this->request->getPost("starttext");
        $image = $_FILES["feedback"]["name"];
        $aantalvragen = $this->request->getPost("aantalvragen");
        $titel = $this->request->getPost("titel");
        $tijdHour = $this->request->getPost("hour");
        $tijdMin = $this->request->getPost("min");
        $tijdSec = $this->request->getPost("sec");
        $tijd = $save->FormatTime($tijdHour, $tijdMin, $tijdSec);
        $type = $this->request->getPost("type");
        $userid = $auth["id"];

        $categorie = '';
        if($this->request->hasPost("new_categorie") && $this->request->getPost("new_categorie") != "")
        {
            $categorie = $save->CreateCategorie($this->request->getPost("new_categorie"));
        }
        else
        {
            $categorie = $save->GetCategorie($this->request->getPost("catagorie"));
        }

        $id = $save->SaveToDb($text, $image, $aantalvragen, $tijd, $titel, $categorie, $type, $userid, $datetime);
        $save->UploadImages($id);

        $save = null;

       $this->response->redirect("/editor?success=new_toets");
    }

    public function editAction()
    {
        //Include basic JS and CSS and do auth check.
        $basic = new BasicPage(2);
        $this->assets->addJs('/js/edit.js');

        // get values from url and if isn't set redirect back to summary page
        $toets_id = $_GET['id'];
        $aantal = (int)$_GET["aantalvragen"];

        if(!is_int($aantal) || $aantal <= 0 || $aantal > 100)
        {
            $aantal = 5;
        }

        // jumbotron for displaying the current test that's being edited
        $this->view->toets_edit = "<div class='jumbotron' style='padding:25px; text-align: center;background-image: none;'><p>Momenteel maakt u een nieuwe vraag aan.</p></div>";

        $newquestion = new NewQuestion();
        $this->view->formheader = $newquestion->ProcessFormHeader($toets_id, -1);
        $this->view->vraag = $newquestion->ProcessQuestion();
        $this->view->amount = $newquestion->ProcessAmount($toets_id);
        $this->view->vraagimage = $newquestion->ProcessImage($toets_id, "0.jpg");
        $this->view->type = $newquestion->ProcessQuestionType("1");
        $this->view->instruction = $newquestion->ProcessInstructions();
        $this->view->answers = $newquestion->ProcessAnswers($aantal, 1);
        $this->view->correct = $newquestion->ProcessCorrectAnswers($aantal, 1);
        $this->view->feedback = $newquestion->ProcessFeedbackAnswers($aantal);
        $this->view->feedbackimages = $newquestion->ProcessFeedbackImage($aantal, $toets_id);
        $this->view->submit = $newquestion->ProcessSubmitButton();
        $this->view->formend = $newquestion->ProcessFormEnd();

        //Get the amount of question and store it in a session for later use,.
        $this->session->set("questionamount", $aantal);
        $this->session->set("questionimages", null);
        $this->session->set("questionimage", "0.jpg");

        $newquestion = null;
    }

    public function configAction()
    {
        $base = new BasicPage(2);

        // get data from url
        $id = $_GET['id'];

        $row = Toetsconfig::findFirst($id);

        $toetsconfig = new EditToetsConfig();

        $this->view->formstart = $toetsconfig->ProcessFormHeader($id);
        $this->view->titel = $toetsconfig->ProcessTitle($row);
        $this->view->categorieen = $toetsconfig->ProcessCategorie($row->categorie);
        $this->view->type = $toetsconfig->ProcessType($row->type);
        $this->view->starttext = $toetsconfig->ProcessEditor($row);
        $this->view->backgroundimage = $toetsconfig->ProcessBackgroundImage($id, $row->bgimage);
        $this->view->aantalvragen = $toetsconfig->ProcessAantalvragen($row);
        $this->view->tijd = $toetsconfig->ProcessTime($row->tijd);
        $this->view->submit = $toetsconfig->ProcessSubmit();
        $this->view->formend = "</form>";

        $toetsconfig = null;
    }

    public function saveconfigAction()
    {
        $save = new NewToetsSave();
        $auth = $this->session->get("auth");
        $id = $_GET["id"];

        $datetime = date( 'Y-m-d H:i:s');
        $text = $this->request->getPost("starttext");
        $image = $_FILES["feedback"]["name"];
        $aantalvragen = $this->request->getPost("aantalvragen");
        $titel = $this->request->getPost("titel");
        $tijdHour = $this->request->getPost("hour");
        $tijdMin = $this->request->getPost("min");
        $tijdSec = $this->request->getPost("sec");
        $tijd = $save->FormatTime($tijdHour, $tijdMin, $tijdSec);
        $type = $this->request->getPost("type");
        $userid = $auth["id"];

        $categorie = '';
        if($this->request->hasPost("new_categorie") && $this->request->getPost("new_categorie") != "")
        {
            $categorie = $save->CreateCategorie($this->request->getPost("new_categorie"));
        }
        else
        {
            $categorie = $save->GetCategorie($this->request->getPost("catagorie"));
        }

        if($image == "")
        {
            $result = Toetsconfig::findFirst($id);

            $image = $result->bgimage;
        }

        $id = $save->UpdateRecord($id, $text, $image, $aantalvragen, $tijd, $titel, $categorie, $type, $userid, $datetime);
        $save->UploadImages($id);

        $save = null;

        $this->response->redirect("/editor?success=edit");
    }

    public function questionsAction()
    {
        $toets_id = $_GET['id'];

        $base = new BasicPage(2);
        $this->view->docmenu = '<div class="container-fluid">
                    <ul class="nav navbar-nav">
                        <li><a href="/editor">Mijn toetsen</a></li>
                        <li><a href="/editor/edit?id=' . $toets_id .'">Nieuwe vraag toevoegen</a></li>
                    </ul>
                 </div>
                <br>';


        $toets = Toetsconfig::findFirst($toets_id);
        $this->view->toetsedit = "<div class='jumbotron' style='padding:25px; text-align: center;background-image: none;'><p>Momenteel bekijkt u: " . $toets->titel . "</p></div>";

            // load all questions where toetsen_id matches the id of current test that's being edited
        $questions = Toetsvragen::find("toetsen_id='$toets_id'");

        $html = '';
        $nr = 0;
        foreach($questions as $quest){
            $nr++;

            // check which type of question
            if($quest->type == 1){
                $type = 'Enkel antwoord';
            }elseif($quest->type == 2){
                $type = 'Meerdere antwoorden';
            }else{
                $type = 'Open vraag';
            }

        $html .=
        "<tr id='vraag".$quest->id."'>
            <td>". $nr ."</td>
            <td>". $quest->vraag ."</td>
            <td>". $type ."</td>
            <td><a href='/editor/edit_vraag?id=".$toets_id."&vraagid=".$quest->id."'><div class='linkedit'><i class='fa fa-pencil'></i></div></a></td>
            <td><a href='/editor/delete_quest?id=$quest->id&toetsid=$toets_id'><div class='linkedit'><i class='fa fa-trash-o'></i></div></a></td>
        </tr>";

        }
            // create the table head and add the table parts for the info
        $this->view->showquest = '<table class="table table-striped">
        <tr>
            <th>#</th>
            <th>Vraag</th>
            <th>Type</th>
            <th>Aanpassen</th>
            <th>Verwijderen</th>
        </tr>
        '. $html .'
    </table>';

    }

    public function edit_vraagAction()
    {
        //Include basic JS and CSS and do auth check.
        $base = new BasicPage(2);
        $this->assets->addJs('/js/edit.js');

        //Get the question id and test id.
        $toets_id = $_GET['id'];
        $vraag_id = $_GET['vraagid'];

        if(!is_numeric($toets_id) || $toets_id <= 0)
        {
            $this->response->redirect("/editor/questions?id=" . $toets_id . "#vraag" . $vraag_id . "&error=gettid");
        }

        if(!is_numeric($vraag_id) || $vraag_id <= 0)
        {
            $this->response->redirect("/editor/questions?id=" . $toets_id . "#vraag" . $vraag_id . "&error=getvid");
        }

        //Create instance of the models.
        $toets = Toetsconfig::findFirst($toets_id);
        $vraag = Toetsvragen::findFirst($vraag_id);

        //Decode all JSON from the database.
        $json_goodanswer = json_decode($vraag->correct, true);
        $json_answers = json_decode($vraag->antwoord, true);
        $json_feedback = json_decode($vraag->feedbacktext, true);
        $json_feedbackimage  = json_decode($vraag->feedbackimage, true);
        $json_feedbackimagetext = json_decode($vraag->feedbackimagetext, true);

        //Set the view to display a jumbotron with errors.
        $this->view->toets_edit = "<div class='jumbotron' style='padding:25px; text-align: center;background-image: none;'><p>Momenteel bewerkt u: " . $toets->titel . ".</p></div>";

        //Get the number of questions.
        $aantalvragen = count($json_answers);
        if(isset($_GET["aantalvragen"]))
        {
            $aantalvragen = $_GET["aantalvragen"];
        }

        //Create new instance of the EditQuestion component and assign the views.
        $editquestion = new EditQuestion($aantalvragen);

        $this->view->amount = $editquestion->ProcessAmount($toets_id, $vraag->id);
        $this->view->formheader = $editquestion->ProcessFormHeader($toets_id, $vraag_id);
        $this->view->image = $editquestion->ProcessImage($toets_id, $vraag->vraag_image);
        $this->view->question = $editquestion->ProcessQuestion($vraag->vraag);
        $this->view->type = $editquestion->ProcessQuestionType($vraag->type);
        $this->view->instructions = $editquestion->ProcessInstructions($vraag->instructie);
        $this->view->correctanswers = $editquestion->ProcessCorrectAnswers($json_goodanswer, $vraag->type);
        $this->view->answers = $editquestion->ProcessAnswers($json_answers, $vraag->type);
        $this->view->feedbackanswers = $editquestion->ProcessFeedbackAnswers($json_feedback);
        $this->view->feedbackimage = $editquestion->ProcessFeedbackImage($json_feedbackimage, $json_feedbackimagetext, $toets_id);
        $this->view->formend = $editquestion->ProcessFormEnd();
        $this->view->submit = $editquestion->ProcessSubmitButton();

        $editquestion = null;

        //Get the amount of question and store it in a session for later use,.
        $this->session->set("questionamount", $aantalvragen);
        $this->session->set("questionimages", $json_feedbackimage);
        $this->session->set("questionimage", $vraag->vraag_image);
    }

    public function save_questAction()
    {
        //Get which test id is affected.
        $toetsid = $_GET['id'];
        $id = $_GET['vraagid'];

        $new = false;
        if($id == -1) { $new = true; }

        //If its not a new question, validate the id.
        if(!$new)
        {
            if (!is_numeric($id) || $id <= 0)
            {
                $this->response->redirect("/editor/questions?id=" . $toetsid . "#vraag" . $id . "&error=getvid");
            }
        }

        //Get the amount of question that need to be populated in JSON.
        $amountQuestion = $this->session->get("questionamount");
        $currentImages =  $this->session->get("questionimages");
        $currentImage =  $this->session->get("questionimage");

        //Create a new instance of EditQuestionSave class.
        $editsave = new EditQuestionSave();

        //Prevent people from terminating potential querys, sanity check.
        if(is_numeric($toetsid) && $toetsid >= 0)
        {
            //Get path based on test id.
            $path = 'img/toetsen/' . $toetsid . '/';

            ///Get alle the data that is suppose to go into the query.
            $vraag = $this->request->getPost("vraag");
            $type = $this->request->getPost("select_type");
            $instruction = $this->request->getPost("instructie");

            //Set the type, supply the indentiefiers.
            $c = "correct_radio";
            switch($type)
            {
                case 1:
                    $c = "correct_radio";
                    break;
                case 2:
                    $c = "correct_check_";
                    break;
                case 3:
                    $c = "correct_text_";
                    break;
            }

            $jsonAnswers = $editsave->ToJson($amountQuestion, "antwoord_", false, $type);
            $jsonFeedbackAnswer = $editsave->ToJson($amountQuestion, "feedback_", false, $type);
            $jsonFeedbackImageText = $editsave->ToJson($amountQuestion, "imgfeedback", false, $type);
            $jsonCorrect = $editsave->ToJson($amountQuestion, $c, true, $type);
            $jsonImages = $editsave->ToImageJson($amountQuestion, $currentImages);

            $image = "";
            if($_FILES["image"]["name"] == "")
            {
                $image = $currentImage;
            }else
            {
                $image = $_FILES["image"]["name"];
            }

            if(empty($instruction))
            {
                $instruction = " ";
            }


            if($vraag && $type && $jsonAnswers && $jsonFeedbackAnswer && $jsonFeedbackImageText && $jsonCorrect && $jsonImages && $image) {

                //Upload all the images (that were newly added)
                $editsave->UploadImages($path);
                $hasSaved = $editsave->SaveToDB($toetsid, $type, $vraag, $instruction, $jsonAnswers, $jsonFeedbackAnswer, $jsonImages, $jsonFeedbackImageText, $jsonCorrect, $image, $id, $new);

                if($hasSaved)
                {
                   $this->response->redirect("/editor/questions?id=" . $toetsid . "#vraag" . $id);
                }else
                {
                   $this->response->redirect("/editor/edit_vraag?id=" . $toetsid . "&vraagid=" . $id . "&error=SaveToDb");
                }
            }
            else
            {
                $this->response->redirect("/editor/edit_vraag?id=" . $toetsid . "&vraagid=" . $id . "&error=missing");

            }
            //Unset the instance and remove the sessions.
            $editsave = null;
            $this->session->remove("questionamount");
            $this->session->remove("questionimages");
            $this->session->remove("questionimage");

            $this->response->redirect("/editor/questions?id=" . $toetsid . "#vraag" . $id);
        }
        else
        {
            $this->response->redirect("/editor/questions?id=" . $toetsid . "#vraag" . $id . "&error=gettid");
        }
    }

    public function deleteAction()
    {
        $id = $_GET['id'];
        $auth = $this->session->get("auth");

        $auth_id = $auth['id'];

        $toets = Toetsconfig::findFirst($id);
        if ($toets->userid == $auth_id)
        {
            try {
                $toets->delete();

                $config = Toetsconfig::findFirst("toetsid='$id'");
                $config->delete();

                $toetsvragen = Toetsvragen::find("toetsen_id='$id'");
                foreach ($toetsvragen as $toetsvraag) {
                    $toetsvraag->delete();
                }
            }catch(\Exception $e)
            {
                $this->response->redirect("/editor?error=delete_toets");
            }
        }

        $this->response->redirect("/editor?success=delete_toets");
    }

    public function delete_questAction()
    {
        $vraag_id = $_GET['id'];
        $toets_id = $_GET['toetsid'];

        $toetsvraag = Toetsvragen::findFirst($vraag_id);
        if($toetsvraag->delete())
        {
            $this->response->redirect("/editor/questions?id=$toets_id");
        }
    }
}
?>