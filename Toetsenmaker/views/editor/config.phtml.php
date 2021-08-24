<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Toetsen Maker - Toets Configureren</title>
    <?php $this->assets->outputCss() ?>
    <script type="text/javascript" src="/ckeditor/ckeditor.js"></script>
</head>
    <body>
    <div class="container">

        <div class="jumbotron"><h1>Toets Maker</h1></div>


        <?php echo $navbar; ?>

        <div class="col-md-9">
            <h2 style="text-align: center;margin:  auto 0;">Toets Configureren</h2>
            <?php echo $docmenu; ?>

            <?php echo $formstart; ?>
                <?php echo $titel; ?>
                <?php echo $categorieen; ?>
                <?php echo $type; ?>
                <?php echo $starttext; ?>
                <?php echo $backgroundimage; ?>
                <?php echo $aantalvragen; ?>
                <?php echo $tijd; ?>
                <?php echo $submit; ?>
            <?php echo $formend; ?>
        </div>

        <div class="col-md-3">
            <?php echo $categorie; ?>
        </div>
    </div>
    <?php echo $footer; ?>

    <?php $this->assets->outputJs() ?>
    </body>
</html>