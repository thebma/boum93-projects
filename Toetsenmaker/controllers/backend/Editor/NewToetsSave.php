<?php

class NewToetsSave extends Phalcon\Mvc\User\Component
{
    public function FormatTime($hour, $min, $sec)
    {
        $timeComplete = '';

        if($hour < 10)
        {
            if(strlen((string)$hour) == 1)
            {
                $timeComplete .= "0" . $hour;
            }else
            {
                $timeComplete .= $hour;
            }
        }else
        {
            $timeComplete .= $hour;
        }

        $timeComplete .= ":";

        if($min < 10)
        {
            if(strlen((string)$min) == 1)
            {
                $timeComplete .= "0" . $min;
            }else
            {
                $timeComplete .= $min;
            }
        }else
        {
            $timeComplete .= $min;
        }

        $timeComplete .= ":";

        if($sec < 10)
        {
            if(strlen((string)$sec) == 1)
            {
                $timeComplete .= "0" . $sec;
            }else
            {
                $timeComplete .= $sec;
            }
        }else
        {
            $timeComplete .= $sec;
        }

        return $timeComplete;
    }

    public function CreateCategorie($naam)
    {
        $categorie = new Categorie();
        $categorie->naam = $naam;

        if($categorie->create())
        {
            return $categorie->id;
        }
        else
        {
            return 1;
        }
    }

    public function GetCategorie($naam)
    {
        $categorie = new Categorie();
        $result = $categorie->find();

        foreach($result as $r)
        {
            if(strtolower(trim($r->naam)) == strtolower(trim($naam)))
            {
                return $r->id;
            }
        }

        return 0;
    }

    public function SaveToDb($text, $bgimg, $vragen, $tijd, $titel, $categorie, $type, $userid, $date)
    {
        $toetsconfig = new Toetsconfig();
        $toetsconfig->starttext = $text;
        $toetsconfig->bgimage = $bgimg;
        $toetsconfig->aantalvragen = $vragen;
        $toetsconfig->tijd = $tijd;
        $toetsconfig->titel = $titel;
        $toetsconfig->categorie = $categorie;
        $toetsconfig->type = $type;
        $toetsconfig->userid = $userid;
        $toetsconfig->created = $date;
        $toetsconfig->updated = $date;

        if ($toetsconfig->save())
        {
            return $toetsconfig->id;
        }

        return 0;
    }

    public function UploadImages($toetsid)
    {
        $path = 'img/toetsen/' . $toetsid . '/';

        // check if directory exists and make new with test id if it doesn't
        if(!file_exists($path))
        {
            //Allow full read and owner write.
            mkdir($path, 0777);
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

    public function UpdateRecord($id, $text, $bgimg, $vragen, $tijd, $titel, $categorie, $type, $userid, $date)
    {
        $toetsconfig = Toetsconfig::findFirst($id);

        $toetsconfig->starttext = $text;
        $toetsconfig->bgimage = $bgimg;
        $toetsconfig->aantalvragen = $vragen;
        $toetsconfig->tijd = $tijd;
        $toetsconfig->titel = $titel;
        $toetsconfig->categorie = $categorie;
        $toetsconfig->type = $type;
        $toetsconfig->userid = $userid;
        $toetsconfig->created = $date;
        $toetsconfig->updated = $date;

        if ($toetsconfig->update())
        {
            return $toetsconfig->id;
        }

        return $toetsconfig->getMessages();
    }
}

?>