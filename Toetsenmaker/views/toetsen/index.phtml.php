<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Toets maker</title>
    <?php $this->assets->outputCss() ?>
</head>
<body>
<div class="container">

    <div class="jumbotron"><h1>Toets Maker</h1></div>


<?php echo $navbar; ?>


    <div class="col-md-8">

        <?php echo $docmenu; ?>

        <h2>Mijn examens:</h2>
<pre>
    <h4 style="padding-left: 10px;">Op dit moment zijn er geen toetsen beschikbaar</h4>
</pre>


        <h2>Een oefen examen maken?</h2>



        <p>Om een oefentoets te maken selecteer je in de sidebar de categorie waarop jij wil oefenen. In de categorie zullen een aantal toetsen staan waarmee jij kan oefen. De oefentoetsen bestaat uit 25 vragen die willekeurig uit een lijst met vragen word geselecteerd, elke keer dat je de oefentoets maakt heb je een andere versie.</p>




    </div>

    <div class="col-md-4">

     <?php echo $categorie; ?>
    </div>
    
</div>
<?php echo $footer; ?>

<?php $this->assets->outputJs() ?>
</body>
<html>