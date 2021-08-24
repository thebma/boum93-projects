<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Some amazing website</title>
    <?php $this->assets->outputCss() ?>
</head>
<body>
<div class="container">

    <div class="jumbotron"><h1>Toets Maker</h1></div>


    <?php echo $navbar; ?>


    <div class="col-md-8" style="text-align: center;"><h2 style="/*text-align: center;*/margin:  auto 0;">Mijn toetsen</h2>
        <?php echo $docmenu; ?>

        <?php echo $toetsinfo; ?>

    </div>
    <div class="col-md-4">
        <?php echo $categorie; ?>


    </div>
</div>


<?php $this->assets->outputJs() ?>
</body>
<html>