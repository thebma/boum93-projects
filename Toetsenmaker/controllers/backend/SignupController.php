
<?php

class SignupController extends \Phalcon\Mvc\Controller
{

    public function indexAction()
    {
        //Add some local CSS resources
        $this->assets
            ->addCss('css/bootstrap.css')
            ->addCss('css/index.css');

        //and some local javascript resources
        $this->assets
            ->addJs('js/jquery.js')
            ->addJs('js/bootstrap.js');

        $this->view->navbar = NavBar("Signup" ,$auth["lvl"], $auth["name"]);
        $this->view->footer = footer();
        $klassen = Klas::find();

        foreach($klassen as $klas){
            $klas_option .= "<option class='form-control' value='$klas->klasnaam'>".$klas->klasnaam ."</option>";
        }

        $this->view->klas = "<select class='form-control' name='klas'>".
        $klas_option .= "</select>";

        $signup_feed = $_COOKIE['signup_feed'];

        if(!isset($signup_feed)){
            $this->view->signup_feed  = "";
        }else {
            $this->view->signup_feed = "<div class='jumbotron' style='padding:10px; text-align: center;background-image: none;'><b>" . $signup_feed . "</b></div>";
        }
    }



    public function registerAction()
    {
        $naam = $this->request->getPost('naam');
        $leerlingnr = $this->request->getPost('leerlingnr');
        $email = $this->request->getPost('email');
        $opleiding = $this->request->getPost('opleiding');
        $klas = $this->request->getPost('klas');
        $locatie = $this->request->getPost('locatie');
        $wachtwoord = $this->request->getPost('wachtwoord');
        $repeatPassword = $this->request->getPost('wachtwoordre');
        $pass_check = "";

        if ($wachtwoord != $repeatPassword) {
            $pass_check = 'Wachtwoorden zijn verschillend<br>';
        }

        $user = new Users();
        $user->leerlingnr = $leerlingnr;
        $user->wachtwoord = $this->security->hash($wachtwoord);
        $user->naam = $naam;
        $user->email = $email;
        $user->opleiding = $opleiding;
        $user->klas = $klas;
        $user->lvl = 1;
        $user->locatie = $locatie;
        $user->created_at = new Phalcon\Db\RawValue('now()');
        $user->active = 'Y';
        if ($user->save() == false) {

            $all_message = "";
            foreach ($user->getMessages() as $message) {
                if($message == "wachtwoord is required"){
                    $message = "Wachtwoord is verplicht";
                    $all_message .=   $message . "<br>";
                }
                if($message == "naam is required"){
                    $message = "Naam is verplicht";
                    $all_message .=   $message . "<br>";
                }
                if($message == "email is required"){
                    $message = "Email is verplicht";
                    $all_message .=   $message . "<br>";
                }
                if($message == "opleiding is required"){
                    $message = "Opleidng is verplicht";
                    $all_message .=   $message . "<br>";
                }
            }

            setcookie("signup_feed", "Dit ging er fout: " . $pass_check . $all_message, time()+3);
            //$this->response->redirect('/signup');
        }
        else
        {
          $this->tag->setDefault('email', '');
          $this->tag->setDefault('password', '');
          $this->flash->success('Thanks for sign-up, please validate your email');

          return   $this->response->redirect('../login');
        }

     //$this->view->disable();


    }

}