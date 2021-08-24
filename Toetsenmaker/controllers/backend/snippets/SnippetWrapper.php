<?php

function docmenu($auth){

    if ($auth['lvl'] == 2) {
        return '<div class="container-fluid">
                    <ul class="nav navbar-nav">
                        <li><a href="/editor/create">Nieuwe toets maken</a></li>
                        <li><a href="/editor">Mijn toetsen</a></li>
                    </ul>
                 </div>
                <br>';
    }
}

function accordion($db)
{
    // get toets & categorie info from database -------------------------//
    $phql = 'SELECT * FROM categorie ORDER BY `id`';
    $collapsenr = 0;
    $open = 0;
    $toreturn = "";

    $result = $db->query($phql);
    while ($row = $result->fetch()) {
        $toreturn = $toreturn .
            '<div class="panel-heading" style="padding:0;">
            <h4 class="panel-title">
                <a data-toggle="collapse" /*data-parent="#accordion" href="#collapse' . $open++ . '"><button style="background:none; border:none; padding:15px 0px; width:100%;">
                   ' . $row['naam'] . '
                </button></a>
            </h4>
        </div>
            <div id="collapse' . $collapsenr++ . '" class="panel-collapse collapse">
            <ul class="list-group">';

        $phql2 = "SELECT * FROM `toetsconfig` WHERE `categorie` = '" . $row['id'] . "'";
        $result2 = $db->query($phql2);
        while ($toets = $result2->fetch()) {
            $toreturn = $toreturn .

                '<li class="list-group-item" style="padding:0;"><a href="/starttoets?toetsid=' . $toets['id'] .'">
                 <button style="background:none; border:none; padding:15px 0px; width:100%;">
                ' . $toets['titel'] . '</button></a></li>';
        }
        $toreturn = $toreturn . '</ul>
                </div>';
    }


    return '<h1 style="text-align:center;">categorieën</h1>
        <!-- create the accordion menu -->

<div class="panel-group" id="accordion">
<div class="panel panel-default">' .


    $toreturn
    . '</div>';
}


function check_active_home($page){

    if($page == "Home"){
        return '<li class="active">';
    }
    else{
        return '<li>';
    }

}
    function check_active_toetsen($page){

        if($page == "Toetsen"){
            return '<li class="active">';
        }
        else{
            return '<li>';
        }

    }
    function check_active_result($page)
    {

        if($page == "Result"){
            return '<li class="active">';
        }
        else{
            return '<li>';
        }

    }

    function check_active_admin($page){

        if($page == "Admin"){
            return '<li class="active">';
        }
        else{
            return '<li>';
        }

    }

    function check_active_leerlijnen($page){

        if($page == "Leerlijnen"){
            return '<li class="active">';
        }
        else{
            return '<li>';
        }

    }

    function check_active_leerlijnen2($page){

        if($page == "Leerlijnen2"){
            return '<li class="active">';
        }
        else{
            return '<li>';
        }

    }

    function check_active_login($page){

        if($page == "Login"){
            return '<li class="active">';
        }
        else{
            return '<li>';
        }

    }
    function check_active_signup($page){

        if($page == "Signup"){
            return '<li class="active">';
        }
        else{
            return '<li>';
        }

    }



    function navbar($page, $lvl, $name){

        if($lvl == 2) {
            return '<nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="Index" style="margin-right: 25px;"></a>
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav">

                    ' . check_active_home($page) . Phalcon\Tag::linkTo("/index", "Home"). '</li>
' . check_active_toetsen($page) . Phalcon\Tag::linkTo("/toetsen", "Toetsen") . '</li>
' . check_active_result($page) . Phalcon\Tag::linkTo("/result", "Resultaten") . '</li>
' . check_active_leerlijnen2($page) . Phalcon\Tag::linkTo("http://fcsprint2.nl/leerlijnen", "Leerlijnen ") . '</li>
                </ul>
                
<ul class="nav navbar-nav navbar-right">
    ' . check_active_admin($page) . Phalcon\Tag::linkTo("/admin", "Ingelogd als " . $name) .'</li>
    <li style="margin-top:8px;margin-left:15px;">' . Phalcon\Tag::form("/index/logout") . Phalcon\Tag::submitButton(array("logout", "class" => "btn btn-default")) . '</form></li>
</ul>

</div>
</div>
</nav>';}

        elseif($lvl == 1) {
            return '<nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="Index" style="margin-right: 25px;"></a>
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav">

                ' . check_active_home($page) . Phalcon\Tag::linkTo("/index", "Home"). '</li>
                ' . check_active_toetsen($page) . Phalcon\Tag::linkTo("/toetsen", "Toetsen") . '</li>

</ul>
<ul class="nav navbar-nav navbar-right">
    ' . check_active_admin($page) . Phalcon\Tag::linkTo("/admin", "Ingelogd als " . $name) .'</li>
    <li style="margin-top:8px;margin-left:15px;">' . Phalcon\Tag::form("/index/logout") . Phalcon\Tag::submitButton(array("logout", "class" => "btn btn-default")) . '</form></li>
</ul>

</div>
</div>
</nav>';}


        else{
            return '<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="Index" style="margin-right: 25px;"></a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
                ' . check_active_home($page) . Phalcon\Tag::linkTo("/index", "Home"). '</li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                ' . check_active_signup($page) . Phalcon\Tag::linkTo("/signup", "Registreren") . '</li>
                ' . check_active_login($page) . Phalcon\Tag::linkTo("/login", "Login") . '</li>
            </ul>
        </div>
    </div>
</nav>';



        }
            }
function footer(){
    return '<div class="container"><div class="row">
                <div class="col-md-12" style="text-align: center; margin-top: 50px;">
                    <a href="http://fcsprint2.nl/Bronnen/">© 2015  FC Sprint² Leerbedrijf Bronnen</a>
                </div>
                </div></div>';
}

function ReadSpeakerButton($id)
{

}

