<?php
    ob_start();
    $title = 'Connexion';
?>

<style>
    .form-signin {
        width: 100%;
        max-width: 330px;
        padding: 15px;
        margin: 0 auto;
    }
</style>

<div class="container">
    <div class="row">
        <div class="col">
            <div class="alert alert-info">
                <strong>Utilisateurs :</strong>
                <ul>
                    <li>Administrateur : <code>admin@example.org</code> Mdp: <code>password</code></li>
                    <li>Utilisateur : <code>jon.doe@example.org</code> Mdp: <code>password</code></li>
                    <li>Utilisateur : <code>jane.jackson@example.org</code> Mdp: <code>password</code></li>
                    <li>Utilisateur : <code>miley.reed@example.org</code> Mdp: <code>password</code></li>
                </ul>
            </div>
            <form class="form-signin text-center" method="POST" action="<?= redstr('login') ?>">
                <h1 class="h3 mb-3">Connexion</h1>

                <?php if (isset($bad_credentials)) { ?>
                    <div class="alert alert-danger">
                        Adresse email ou mot de passe invalide.
                    </div>
                <?php } ?>

                <label for="inputEmail">Email</label>
                <input name="email" type="email" id="inputEmail" class="form-control mb-3" placeholder="Email" required="" autofocus="">
                
                <label for="inputPassword">Mot de passe</label>
                <input name="password" type="password" id="inputPassword" class="form-control mb-3" placeholder="Password" required="">
                
                <button class="btn btn-lg btn-primary btn-block" type="submit">Se connecter</button>
            </form>
        </div>
    </div>
</div>

<?php
    $content = ob_get_clean();
    require_once('views/partials/layout.php');
?>