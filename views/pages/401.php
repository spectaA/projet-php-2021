<?php
    ob_start();
    $title = '401';
?>

<div class="container">
    <div class="row">
        <div class="col my-5 text-center">
            <h1 class="mb-5">401 - Page restreinte</h1>
            <?php if (isset($msg)) { ?>
                <p class="lead"><?= $msg ?></p>
            <?php } ?>
            <h2 class="mb-5">Veuillez vous connecter</h2>
            <div class="mb-5">
                <a class="btn btn-primary" href="<?= redstr('login') ?>">Connexion</a>
            </div>
            <div class="mb-5">
                <a href="<?= redstr('') ?>">Retour à l'accueil</a>
            </div>
            <div class="mb-5">
                <p class="text-muted" id="redirect-container">
                    <input type="checkbox" id="redirect" checked="checked">
                    Redirection dans <span id="time">3</span> secondes...
                </p>
            </div>
        </div>
    </div>
</div>

<script>
    let i = 4000;
    const interval = setInterval(() => {
        document.getElementById("time").textContent = Number(i / 1000).toFixed(0);
        i -= 100;
    }, 100);
    setTimeout(() => {
        if (document.getElementById("redirect").checked) {
            window.location.href = "<?= redstr('login') ?>";
        }
        document.getElementById("redirect-container").outerHTML = "";
        clearInterval(interval);
    }, i);
</script>

<?php
    $content = ob_get_clean();
    require_once('views/partials/layout.php');
?>