<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Toets maker - Interne error</title>
    <?php $this->assets->outputCss() ?>
</head>
<body>
<div class="container">

    <div class="jumbotron"><h1>Toets Maker</h1></div>


    <?php echo $navbar; ?>

    <div class="row">
        <div class="col-md-12">
            <h1>Interne server error</h1>

            <p>Er heeft zich een error voorgedaan op de pagina. Wij verzoeken u ons te contacteren als dit probleem zich vaker voordoet
                <br/><br/>
                - Terug keren naar de <a href="/">homepagina</a>.
                <br/>
                - De website beheerder contacteren als u denkt dat dit een fout is. <br/>
                &emsp;U kunt het onderstaande email adress contacteren als deze fout meerdere malen voordoet:
                <br/>&emsp;Email:  <a href="mailto:getlost@fcsprint.nl">getlost@fcsprint.nl</a>
            </p>

        </div>
    </div>
</div>
<?php echo $footer; ?>

<?php $this->assets->outputJs() ?>
</body>
<html>