<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Toets maker</title>
    <?php $this->assets->outputCss() ?>
</head>
<body>
<div class="container">
    <?php use Phalcon\Tag; ?>
    <div class="jumbotron"><h1>Toets Maker</h1></div>


    <?php echo $navbar; ?>
    </form>
<div class="row">
    <div class="col-md-8">
        <?php echo $select; ?>
        <?php echo $result_data; ?>
    </div>

    <div class="col-md-4">



        <?php echo $categorie; ?>

    </div>
</div>
    <?php echo $footer; ?>
</div>

<?php $this->assets->outputJs() ?>
</body>
<html>