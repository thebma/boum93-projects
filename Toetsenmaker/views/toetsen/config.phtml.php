<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Some amazing website</title>
    <?php $this->assets->outputCss() ?>
    <script type="text/javascript" src="/ckeditor/ckeditor.js"></script>
</head>
<body>
<div class="container">

    <div class="jumbotron"><h1>Toets Maker</h1></div>


    <?php echo $navbar; ?>

    <div class="col-md-8"><h2 style="text-align: center;margin:  auto 0;">Toetsen bewerken</h2>
        <?php echo $docmenu; ?>
        <?php echo $feedback; ?>
<?php echo $config; ?>

        <div class="modal fade" id="quest_image" tabindex="-1" role="dialog" aria-labelledby="quest_imageLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Upload afbeelding bij vraag.</h4>
                    </div>
                    <div class="modal-body">

                        <form action="/toetsen/add_configimage?id=<?php echo $toets_id; ?>" method="post" enctype="multipart/form-data">
                            <input type="file" name="files[]" class="btn btn-default" multiple>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <input type="submit" name="submit" class="btn btn-primary">
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="col-md-4">
        <?php echo $categorie; ?>


    </div>
</div>


<?php $this->assets->outputJs() ?>
</body>
<html>