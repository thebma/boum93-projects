<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" >
    <title>Entree opleiding niveau 1 en 2s</title>
    <?php $this->assets->outputCss() ?>
    <script type="text/javascript" src="../../../public/readspeaker/readspeaker.js"></script>
    <script src="http://f1.eu.readspeaker.com/script/5/ReadSpeaker.js?pids=embhl" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="../../../public/readspeaker/readspeakerskin.css"/>
    <script type="text/javascript">
        <!--
        window.rsConf = {general: {usePost: true}};
        //-->
    </script>
</head>

<body>
    <?php echo $background; ?>

    <div id="box">


        <div id="title">
            <h1><?php echo $title; ?></h1>
        </div>

        <div id="content"">
        <div id="readspeaker_button1" class="rs_skip rsbtn rs_preserve">
            <a rel="nofollow" class="rsbtn_play" accesskey="L" title="Laat de tekst voorlezen met ReadSpeaker" href="http://app.eu.readspeaker.com/cgi-bin/rsent?customerid=5&amp;lang=nl_nl&amp;voice=Ilse&amp;readid=content&amp;url=http://jahwah.nl/starttoets?toetsid=1">
                <span class="rsbtn_left rsimg rspart"><span class="rsbtn_text"><span>Lees voor</span></span></span>
                <span class="rsbtn_right rsimg rsplay rspart"></span>
            </a>
        </div>
            <p id="starttext">
                <?php echo $content; ?>
            </p>
        </div>

        <div id="start-wrapper">
            <?php echo $start; ?>
        </div>
    </div>


    <?php $this->assets->outputJs() ?>

</body>
<html>