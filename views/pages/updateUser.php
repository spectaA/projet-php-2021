<?php
    ob_start();
    $title = '400';
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
            <form class="text-center" method="POST" action="<?= isset($user) ? redstr('updateUser') : redstr('createUser') ?>">
                <h1 class="h3 mb-3">Utilisateur</h1>
                <?php if(isset($user)) { ?>
                    <input type="hidden" name="user_id" value="<?= $user->id ?>">
                <?php } ?>

                <label>Prénom</label>
                <input type="text" maxlength="100" name="firstname" class="form-control mb-3" required="" value="<?= isset($user) ? $user->firstname : '' ?>">

                <label>Nom</label>
                <input type="text" maxlength="100" name="lastname" class="form-control mb-3" required="" value="<?= isset($user) ? $user->lastname : '' ?>">

                <label>Date d'anniversaire</label>
                <input type="date" name="birthday" class="form-control mb-3" required="" value="<?= isset($user) ? date('Y-m-d', strtotime($user->birthday)) : '' ?>">

                <label>Téléphone</label><br>
                <label><small>10 charactères numériques</small></label>
                <input type="tel" pattern="[0-9]{1,10}" name="phone" class="form-control mb-3" required="" value="<?= isset($user) ? $user->phone : '' ?>">

                <label>Email</label>
                <input type="email" name="email" class="form-control mb-3" required="" value="<?= isset($user) ? $user->email : '' ?>">

                <?php if (isset($_SESSION['admin'])) { ?>
                    <label>Role</label>
                    <select class="form-select mb-3" name="role">
                        <option value="user" <?= isset($user) && $user->role == 'user' ? 'selected' : '' ?>>Utilisateur</option>
                        <option value="admin" <?= isset($user) && $user->role == 'admin' ? 'selected' : '' ?>>Administrateur</option>
                    </select>
                <?php } ?>

                <button class="btn btn-lg btn-primary btn-block" type="submit"><?= isset($user) ? 'Modifier' : 'Ajouter' ?></button>
            </form>
        </div>
    </div>
</div>

<?php
    $content = ob_get_clean();
    require_once('views/partials/layout.php');
?>