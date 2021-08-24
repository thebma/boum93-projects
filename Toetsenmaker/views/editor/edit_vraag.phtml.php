<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Toets maker - Edit vraag</title>
    <?php $this->assets->outputCss() ?>
</head>
<body>

<div class="container">

    <div class="jumbotron"><h1>Toets Maker</h1></div>


    <?php echo $navbar; ?>

    <div class="col-md-9 'form-group">
        <?php echo $formheader; ?>
            <?php echo $docmenu; ?>
            <?php echo $toets_edit; ?>
            <?php echo $amount; ?>
            <?php echo $question; ?>
            <?php echo $image; ?>
            <?php echo $type; ?>
            <?php echo $instructions; ?>
            <?php echo $answers; ?>
            <?php echo $correctanswers; ?>
            <?php echo $feedbackanswers; ?>
            <?php echo $feedbackimage; ?>
        <?php echo $formend; ?>

        <div class="col-md-9">
            <?php echo $submit; ?>
        </div>
    </div>

    <div class="col-md-3">
        <?php echo $categorie; ?>
    </div>

</div>
<?php echo $footer; ?>

<?php $this->assets->outputJs() ?>
</body>
<html>