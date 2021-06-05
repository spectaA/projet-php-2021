<?php
    ob_start();
    $title = (isset($center) ? 'Modifier' : 'Créer').' un centre';
?>

<style>
    form {
        width: 100%;
        max-width: 450px;
        padding: 15px;
        margin: 0 auto;
    }
</style>

<div class="container">
    <div class="row">
        <div class="col">
            <form class="text-center" method="POST" action="<?= isset($center) ? redstr('updateCenter') : redstr('createCenter') ?>">
                <h1 class="h3 mb-3">Centre de vaccination</h1>
                <?php if(isset($center)) { ?>
                    <input type="hidden" name="center_id" value="<?= $center->id ?>">
                <?php } ?>

                <label>Nom</label>
                <input type="text" maxlength="45" name="name" class="form-control mb-3" required="" value="<?= isset($center) ? $center->name : '' ?>">

                <label>Ville</label>
                <input type="text" maxlength="45" name="city" class="form-control mb-3" required="" value="<?= isset($center) ? $center->city : '' ?>">

                <label>Code postal</label>
                <input type="number" min="0" max="9999" name="postalCode" class="form-control mb-3" required="" value="<?= isset($center) ? $center->postalCode : '' ?>">

                <label>Adresse</label>
                <input type="text" maxlength="100" name="address" class="form-control mb-3" required="" value="<?= isset($center) ? $center->address : '' ?>">

                <button class="btn btn-lg btn-primary btn-block" type="submit"><?= isset($center) ? 'Modifier' : 'Ajouter' ?></button>
            </form>
        </div>
    </div>
</div>

<?php
    $content = ob_get_clean();
    require_once('views/partials/layout.php');
?>