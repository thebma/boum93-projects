
<?php

class loginController extends \Phalcon\Mvc\Controller
{

    public function indexAction()
    {
       $base = new BasicPage(0);

        $this->view->navbar .=      '<div class="row">
                <div class="col-md-4">
                </div>

                <div class="col-md-4">
                    <h2 style="text-align: center;">Login</h2>
                    <table class="table">
                        ' . $this->tag->form("login/start") . '
                        <tr>
                            <td style="border:none;">
                                <label for="email" style="margin-top:5%;">Leerlingnr/Email</label>
                            </td>
                            <td style="border:none;">
                                ' . $this->tag->textField(array("email", "size" => "30", "class" => "form-control")) . '
                            </td>
                        </tr>
                        <tr>
                            <td style="border:none;">
                                <label for="wachtwoord" style="margin-top:5%;">Wachtwoord</label>
                            </td>
                            <td style="border:none;">
                                ' . $this->tag->passwordField(array("wachtwoord", "size" => "30", "class" => "form-control")) . '
                            </td>
                        </tr>
                        <tr>
                            <td style="border:none;"></td>
                            <td style="border:none;">
                                ' . $this->tag->submitButton(array("Login", "class" => "btn btn-primary")) . '
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="col-md-4">
                </div>

            </div>';

 }

    private function _registerSession(Users $user)
    {
        $this->session->set('auth', array(
            'id'        => $user->id,
            'name'      => $user->naam,
            'lvl'       => $user->lvl,
            'location'  => $user->locatie,
            'class'     => $user->klas,
            'email'     => $user->email,
            'create'    => $user->created_at,
            'studentnr' => $user->leerlingnr,
            'study'     => $user->opleiding

        ));
    }



    /**
     * This action authenticate and logs an user into the application
     *
     */
    public function startAction()
    {
        if ($this->request->isPost())
        {
            $email = $this->request->getPost('email');
            $wachtwoord = $this->request->getPost('wachtwoord');

            $user = Users::findFirst(array(
                "(email = :email: OR naam = :email:)",
                'bind' => array('email' => "$email")));

            if ($user)
            {
                if ($this->security->checkHash($wachtwoord, $user->wachtwoord))
                {
                    $this->_registerSession($user);
                    $this->response->redirect('/?success=login');
                }
                else
                {
                    $this->response->redirect('/login?error=credentials');
                }
            }
            else
            {
                $this->response->redirect('/login?error=login_user');
            }

        }
    }


    public function endAction()
    {
        $this->session->remove('auth');
        $this->response->redirect('../index');
    }
}