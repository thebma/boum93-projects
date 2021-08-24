<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Toets Maker</title>
    <?php $this->assets->outputCss() ?>
</head>
<body>
<div class="container">

    <?php echo $error; ?>

    <div class="jumbotron"><h1>Toets Maker</h1></div>


    <?php echo $navbar; ?>


    <div class="col-md-9" style="text-align: center;"><h2 style="/*text-align: center;*/margin:  auto 0;">Mijn toetsen</h2>
        <?php echo $docmenu; ?>

        <p style="text-align: justify;"><strong>Dit is het overzicht van alle toetsen die u heeft gemaakt. </strong><ul style="text-align: justify;"><li> Bij de knop bewerk krijgt u een overzicht van de vragen die in de toets zitten, daar kunt
            u ook vragen bewerken en nieuwe vragen toevoegen.</li> <li>Bij de knop config krijgt u de mogelijkheid om de intro tekst, de titel, tijd en het aantal vragen aanpassen.</li><li>Bij de knop delete verwijderd u de toets met de configuratie en alle vragen.</li></p>
        <?php echo $toetsinfo; ?>

    </div>
    <div class="col-md-3">
        <?php echo $categorie; ?>


    </div>
</div>
<?php echo $footer; ?>

<?php $this->assets->outputJs() ?>
</body>
<html>