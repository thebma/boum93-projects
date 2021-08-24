<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Toets maker</title>
    <?php $this->assets->outputCss() ?>
</head>
<body>
<div class="container">

    <div class="jumbotron"><h1>Toets Maker</h1></div>


   <?php echo $navbar; ?>

    <div class="row">

    <div class="col-md-4">




    </div>
    <div class="col-md-4">

        <?php use Phalcon\Tag; ?>

        <?php echo $signup_feed; ?>
        <?php echo Tag::form("/signup/register"); ?>
            <div class="form-group">
                <label for="name">Naam:</label>
                <?php echo Tag::textField(array("naam", "class" => "form-control")) ?>
            </div>
            <div class="form-group">
                <label for="name">Leerlingnummer:</label>
                <?php echo Tag::textField(array("leerlingnr", "class" => "form-control")) ?>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <?php echo Tag::textField(array("email", "class" => "form-control")) ?>
            </div>
            <div class="form-group">
                <label for="name">Opleiding:</label>
                <?php echo Tag::textField(array("opleiding", "class" => "form-control")) ?>
            </div>
            <div class="form-group">
                <label for="name">Klas:</label> <br>
                <?php echo $klas; ?>
            </div>
            <div class="form-group">
                <label for="name">Locatie:</label>
                <?php echo Tag::textField(array("locatie", "class" => "form-control")) ?>
            </div>
            <div class="form-group">
                <label for="wachtwoord">Wachtwoord:</label>
                <?php echo Tag::passwordField(array("wachtwoord", "class" => "form-control")) ?>
            </div>
            <div class="form-group">
                <label for="wachtwoord">Typ wachtwoord opnieuw:</label>
                <?php echo Tag::passwordField(array("wachtwoordre", "class" => "form-control")) ?>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Registreren" />
            </div>
            </form>


    </div>
    <div class="col-md-4"></div>
    </div>
</div>
<?php echo $footer; ?>

<?php $this->assets->outputJs() ?>
</body>
<html>