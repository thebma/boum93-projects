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

<?php echo $upload; ?>


    </div>

    <div class="col-md-4">

        <?php echo $categorie; ?>
    </div>

</div>


<?php $this->assets->outputJs() ?>
</body>
<html>