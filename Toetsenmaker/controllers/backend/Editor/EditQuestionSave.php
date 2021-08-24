<?php

class EditQuestionSave extends Phalcon\Mvc\User\Component
{
    public function UploadImages($path)
    {
        // check if directory exists and make new with test id if it doesn't
        if(!file_exists($path))
        {
            //Allow full read and owner write.
            mkdir($path, 0644);
        }

        //Get all uploaded files.
        foreach ($this->request->getUploadedFiles() as $file)
        {
            //Check if its an image.
            if(strstr(strtolower($file->getRealType()), "image"))
            {
                //Check file size --- Mb's  Kb's  Bytes
                if($file->getSize() < (10 * 1024 * 1024))
                {
                    //Move the file to the correct folder.
                    $file->moveTo($path . "/" . $file->getName());
                }
                else
                {
                    //TODO: Send a error message that size was too big.
                    echo "Size FAIL <br/>";
                }

            }else
            {
                //TODO: Send a error message that extension is not allowed.
                echo "Extension FAIL <br/>";
            }
        }
    }

    public function ToJson($amount, $identifier, $correct, $type)
    {
        $jsonarray = array();
        for($a = 0; $a < $amount; $a++)
        {
            $id = $a + 1;
            if(!$correct)
            {
                if ($this->request->hasPost($identifier . $id))
                {
                    array_push($jsonarray, $this->request->getPost($identifier . $id));
                }
            }
            else
            {
                switch($type)
                {
                    case 1:
                        if($this->request->hasPost($identifier))
                        {
                            $post = $this->request->getPost($identifier);
                            if (is_numeric($post))
                            {
                                $correct = $post;
                            }
                        }

                        if($correct == $id)
                        {
                            array_push($jsonarray, 1);
                        }
                        else
                        {
                            array_push($jsonarray, 0);
                        }
                        break;
                    case 2:
                        if ($this->request->hasPost($identifier . $id))
                        {
                            array_push($jsonarray, 1);
                        }
                        else
                        {
                            array_push($jsonarray, 0);
                        }
                        break;
                    case 3:
                        if ($this->request->hasPost($identifier . $id))
                        {
                            array_push($jsonarray, $this->request->getPost($identifier . $id));
                        }else
                        {
                            array_push($jsonarray, "");
                        }
                        break;
                    default:
                        if ($this->request->hasPost($identifier . $id))
                        {
                            array_push($jsonarray, 1);
                        }
                        else
                        {
                            array_push($jsonarray, 0);
                        }
                        break;
                }
            }
        }

        return json_encode($jsonarray, JSON_FORCE_OBJECT);

    }

    public function ToImageJson($amount, $existing)
    {
        $data = $_FILES;
        $identifier = "feedback";

        $imgarray = array();
        for($a = 0; $a < $amount; $a++)
        {
            $id = $a + 1;

            $key = $identifier . $id;
            if(array_key_exists($key, $data))
            {
                if($data[$key]["name"] != "")
                {
                    array_push($imgarray, $data[$key]["name"]);
                }
                else
                {
                    $oldImg = $existing[$a];
                    if($oldImg == "")
                    {
                        array_push($imgarray, "0.jpg");
                    }
                    else
                    {
                        array_push($imgarray, $existing[$a]);
                    }
                }

            }
        }

        return json_encode($imgarray, JSON_FORCE_OBJECT);

    }

    public function SaveToDb($toetsen_id, $type, $vraag, $instructie, $antwoord, $feedbacktext, $feedbackimage, $feedbackimagetext, $correct, $image, $vraagid, $new)
    {
        try
        {
            if ($new) {
                $phql = "INSERT INTO `toetsvragen` VALUES (null, :toetsid, :types,:vraag,:instructie,:antwoord,:feedbacktext,:feedbackimage,:feedbackimagetext,:correct,:image)";
                $db = $this->getDI()->get('db');

                $db->execute($phql, array(
                    'toetsid' => $toetsen_id,
                    'types' => $type,
                    'vraag' => $vraag,
                    'instructie' => $instructie,
                    'antwoord' => $antwoord,
                    'feedbacktext' => $feedbacktext,
                    'feedbackimage' => $feedbackimage,
                    'feedbackimagetext' => $feedbackimagetext,
                    'correct' => $correct,
                    'image' => $image
                ));
            }
            else
            {
                $phql = "UPDATE `toetsvragen` SET `toetsen_id`=:toetsid,`type`=:types,`vraag`=:vraag,`instructie`=:instructie,`antwoord`=:antwoord,`feedbacktext`=:feedbacktext, `feedbackimage`=:feedbackimage,`feedbackimagetext` =:feedbackimagetext, `correct`=:correct,`vraag_image`=:image WHERE `id`=:vraagid";
                $db = $this->getDI()->get('db');

                $db->execute($phql, array(
                    'toetsid' => $toetsen_id,
                    'types' => $type,
                    'vraag' => $vraag,
                    'instructie' => $instructie,
                    'antwoord' => $antwoord,
                    'feedbacktext' => $feedbacktext,
                    'feedbackimage' => $feedbackimage,
                    'feedbackimagetext' => $feedbackimagetext,
                    'correct' => $correct,
                    'image' => $image,
                    'vraagid' => $vraagid
                ));
            }
        }
        catch(Exception $e)
        {
          return false;
        }
        return true;
    }


}

