<?php

class QuestionElements extends Phalcon\Mvc\User\Component
{
    public $modals;

    public function CreateSingleAnswer($key, $question, $checked = false)
    {
        $check = $checked ? "checked" : "";

        $jsOnClick = intval($type) == 2 ? "ShowFeedback(' . $key . ');" : $type;

        $html = $this->CreateReadSpeakerButton("", "span" . $key);
        $html .= '<div class="radio answerOption">
                    <div id="answer-' . $key . '">
                    </div>
                        <label id="label-' . $key . '">
                            <input ' . $check . ' onclick="ShowFeedback('.$key.')" value="' . $key . '" type="radio" name="answer"><span id="span' . $key . '">' . $question . '</span></input>
                        </label>
                 </div>';

        return $html;
    }

    public function CreateMultipleAnswer($key, $question, $checked = false)
    {
        $check = $checked ? "checked" : "";

        $html = $this->CreateReadSpeakerButton("", "span" . $key);
        $html = '<div class="checkbox">
                    <div id="answer-' . $key . '">
                    </div>
                  <label id="label-' . $key . '">
                        <input ' . $check . ' onclick="ShowFeedback('.$key.')" value="' . $key . '" type="checkbox" name="answer' . $key . '"/><span id="span' . $key . '">' . $question . '</span></input>
                    </label>
                </div>';

        return $html;
    }

    public function CreateInputAnswer($key, $question, $id, $value)
    {
        $input = '<input onfocus="ShowFeedbackInput('.$key.')" onkeyup="UpdateTime()" class="display-ib" id="' . $key . '" type="text" name="answer' . $key . '" value="' . $value . '"/>';

        $replace_array = array('[input]');
        $result = str_replace($replace_array, $input, $question);

        $result .= "<br/>";

        return $result;
    }

    public function CreateFeedback($id, $toetsid, $text, $image, $imagetext)
    {
        $imgZoom = '<img src="/public/img/toetsen/' . $toetsid . '/' . $image . '" id="zoom-img" class="img-responsive center-block" alt="feedbackimagetag"/>';
        $this->modals .= $this->AddZoomModal($id, $imgZoom);


        $html = '';
        $html .= '<div style="display:none;" id="feedback-wrapper-' . $id . '" class="feedback-wrapper">';
        $html .= '<div id="fbt' . $id . '" class="feedbacktext">' . $text . '</div>';
        $html .= $this->CreateReadSpeakerButton("Lees feedback voor.", "fbt" . $id);
        $html .= '<div class="feedbackimage" class="container-fluid">';
        $html .= '<img src="/public/img/toetsen/' . $toetsid . '/' . $image . '" id="feedbackimgtag" class="img-responsive center-block" alt="feedbackimagetag"/>';
      //  $html .= $this->AddZoomButton($id);
        $html .= $this->CreateReadSpeakerButton("", "fbit" . $id);
        $html .= '<span id= "fbit' . $id . '" "class="feedbackimagetext">' . $imagetext . '</span>';
        $html .= '</div><div id="closeclick"><i onclick="CloseAllFeedback();" id="close" class="fa fa-times-circle-o fa-1x red"><span id="closetext">Sluit</span></i></div><div class="clearfix"></div></div>';

        return $html;
    }

    public function CreateEmptyFeedback($id)
    {
        $html = '<div id="feedback-wrapper-' . $id . '" ></div>';
        return $html;
    }

    private $readSpeakButtonCount = 0;

    public function CreateReadSpeakerButton($title, $element)
    {
        $this->readSpeakButtonCount++;

        $html = '';
        $html .= "<div id='rsbutton" . $this->readSpeakButtonCount . "' class='rs_skip rsbtn rs_preserve rs_custom'>";
        $html .= "<a rel='nofollow' class='rsbtn_play' accesskey='L' title='" . $title . "' href='http://app.eu.readspeaker.com/cgi-bin/rsent?customerid=5&amp;lang=nl_nl&amp;readid=" . $element . "&amp;url=http://www.toetsmaker.fcsprint2.nl/vraagtoets/'>";
        $html .= "<span class='rsbtn_left rsimg rspart'><span class='rsbtn_text'><span>" . $title . "</span></span></span><span class='rsbtn_right rsimg rsplay rspart'></span></a></div>";

        return $html;
    }

    public function AddZoomModal($id, $content)
    {
        $html = "<div class='modal fade' id='zoom_img_feedback" . $id . "' tabindex='-1' role='dialog' aria-labelledby='zoom_img_feedback" . $id . "' aria-hidden='true'>";
        $html .= "<div class='modal-dialog'></div><div class='modal-content'>";
        $html .= $content;
        $html .= "</div></div></div>";

        return $html;
    }

    public function AddZoomButton($id)
    {
        $html = "<i id='zoom_feedback_" . $id . " class='fa fa-search col-md-offset-2'>'";
        $html .= "<a data-toggle='modal' data-target='#zoom_img_feedback" . $id . "'> Klik om te vergroten </a></i>";

        return $html;
    }
}
