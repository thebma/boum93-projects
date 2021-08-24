<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Toets Maker - Vraag nieuw</title>
    <?php $this->assets->outputCss() ?>
</head>
<body>
<div class="container">

    <div class="jumbotron"><h1>Toets Maker</h1></div>


    <?php echo $navbar; ?>

    <div class="col-md-9"><h2 style="text-align: center; margin: auto 0;">Toetsen bewerken</h2>
        <?php echo $docmenu; ?>
        <?php echo $toets_edit; ?>

        <?php echo $amount; ?>

        <?php echo $formheader; ?>
            <?php echo $vraag; ?>
            <?php echo $vraagimage; ?>
            <?php echo $instruction; ?>
            <?php echo $type; ?>
            <?php echo $answers; ?>
            <?php echo $correct; ?>
            <?php echo $feedback; ?>
            <?php echo $feedbackimages; ?>
            <?php echo $submit; ?>
        <?php echo $formend; ?>
    </div>
    <div class="col-md-3">
</div>
<?php echo $footer; ?>

<?php $this->assets->outputJs() ?>
</body>
<html>