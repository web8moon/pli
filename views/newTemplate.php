
<?php if(!isset($content)){ ob_start(); ?>
    <h1>Переопределенный контент</h1>

    <?php $content = ob_get_clean();} ?>

<?php require 'baseTemplate.php'; ?>


