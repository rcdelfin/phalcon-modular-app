<?php $this->tag->appendTitle(' - Phalcon modular application');
?><!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <?php echo Phalcon\Tag::getTitle(); ?>
        <?php $this->assets->outputCss('css') ?>
        <?php $this->assets->outputJs('js') ?>
    </head>
    <body>
        <div class="content">
            <?php echo $this->getContent(); ?>
        </div>
    </body>
</html>