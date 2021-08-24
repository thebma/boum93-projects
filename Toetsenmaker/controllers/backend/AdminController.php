<?php

class adminController extends \Phalcon\Mvc\Controller
{

    public function index()
    {
    }


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

        $auth = $this->session->get("auth");
        $toets = $this->session->get("toets");

        $this->view->navbar = NavBar("Admin" ,$auth["lvl"], $auth["name"]);

        $email = '';
        $submit =  '';
        if($auth['lvl'] == 2)
        {
            $submit = '<input type="submit" class="btn btn-primary" value="Update" />';
            $email = Phalcon\Tag::textField(array ("email", "value" =>$auth['email']));
        }
        else
        {
            $submit = '';
            $email = $auth["email"];
        }



        $this->view->userdata ='
<h2>Gebruikers gegevens</h2>'
            . Phalcon\Tag::form("admin/update").
          '<table class="table table-striped">
      <tr>
        <th>Naam</th>
        <td>' . $auth["name"] . '</td>

                </tr>
      <tr>
        <th>Leerlingnummer</th>
        <td>' . $auth['studentnr'] . '</td>
      </tr>
      <tr>
        <th>Email</th>
        <td>' . $email . '</td>
      </tr>
      <tr>
        <th>Opleiding</th>
        <td>' . $auth['study'] . '</td>
      </tr>
      <tr>
        <th>Klas</th>
        <td>' . $auth['class'] . '</td>
      </tr>
      <tr>
        <th>Locatie</th>
        <td>' . $auth['location'] . '</td>
      </tr>
      <tr>
        <th></th>
        <td>' . Phalcon\Tag::hiddenField(array("id", "value" =>$auth['id'])) . '</td>
      </tr>
      <tr>
        <th></th>
        <td>' . $submit . '</td>
      </tr>
  </table></form>
        ';

        $db = $this->getDI()->get('db');

        $this->view->categorie = accordion($db);
        $this->view->footer = footer();
    }

    public function updateAction()
    {
            // get post info
        $auth = $this->session->get("auth");
        $email = $this->request->getPost('email');
        $userid = $this->request->getPost('id');

            // update user email
        if($userid > 0)
        {
            $phql = 'UPDATE users SET email = :email WHERE id = :id';

            $db = $this->getDI()->get('db');
            $db->execute($phql,array('email' => $email, 'id' => $userid));
        }
        else
        {
            throw new \UnexpectedValueException('ID is required for update');
        }

        $auth['email'] = $email;
        $this->session->set('auth', $auth);

        return $this->response->redirect('/admin');
    }
}