<?php
    ob_start();
    $title = '404';
?>

<div class="container">
    <div class="row">
        <div class="col my-5 text-center">
            <h1 class="mb-5">404 - Page introuvable</h1>
            <?php if (isset($msg)) { ?>
                <p class="lead"><?= $msg ?></p>
            <?php } ?>
            <a href="<?= redstr('') ?>">Retour à l'accueil</a>
        </div>
    </div>
</div>

<?php
    $content = ob_get_clean();
    require_once('views/partials/layout.php');
?>