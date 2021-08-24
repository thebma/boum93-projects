<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Toets maker</title>
    <?php $this->assets->outputCss() ?>
</head>
<body>

<div class="container">

    <?php echo $error; ?>

    <div class="jumbotron"><h1>Toets Maker</h1></div>

    <?php echo $navbar; ?>

    <div class="row">
        <div class="col-md-12">
            <h1>Welkom op ons toets systeem.</h1>

            <p>Deze webapplicatie gemaakt door het leerbedrijf bronnen voor leerlingen en docenten, om gemakkelijk toetsen te maken en je resultaat te zien.</p>

            <h3>Waar is dit toets systeem voor?</h3>

            <ul>
                <li>Oefenversies van toetsen maken.</li>
                <li>De resultaten en vooruitgang zien van je oefentoets.</li>
                <li>Inzicht krijgen op de punten waaraan je nog meer aandacht moet besteden.</li>
                <li>Online je toetsen maken.</li>
                <li>Gelijk het resultaat van je toets weten.</li>
            </ul>
        </div>
      </div>
</div>
<?php echo $footer; ?>

<?php $this->assets->outputJs() ?>
</body>
<html>