<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= 'KVAX - '.$title ?></title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
</head>
<body class="d-flex flex-column h-100">
    <header class="mb-5">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand" href="<?= $_SERVER['PHP_SELF'] ?>">KVAX</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <?php if (isset($_SESSION['user_id'])) { ?>
                    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                        <div class="navbar-nav">
                            <a class="nav-link" href="<?= $_SERVER['PHP_SELF'] ?>">Accueil</a>
                            <?php if (isset($_SESSION["admin"])) { ?>
                                <a class="nav-link" href="<?= redstr('getUsers') ?>">Utilisateurs</a>
                                <a class="nav-link" href="<?= redstr('getCenters') ?>">Centres de vaccination</a>
                                <a class="nav-link" href="<?= redstr('getStats') ?>">Statistiques</a>
                            <?php } else { ?>
                                <a class="nav-link" href="<?= redstr('getMyProfile') ?>">Mes disponibilit??s</a>
                            <?php } ?>
                            <a class="d-inline-block d-lg-none nav-link" href="<?= redstr('getMyProfile') ?>">Mon profil</a>
                        </div>
                    </div>
                    <div class="d-flex d-none d-lg-block">
                        <a class="text-dark" href="<?= redstr('getMyProfile') ?>" style="text-decoration:none;">
                            <div class="d-inline-block mx-2">
                                <?= $_SESSION['user_fullname'] ?>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                                <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
                            </svg>
                        </a>
                    </div>
                <?php } else { ?>
                    <div class="d-flex d-none d-lg-block">
                        <a class="text-dark mx-3" href="<?= redstr('login') ?>" style="text-decoration:none;">
                            Se connecter
                        </a>
                        <a class="text-dark" href="<?= redstr('signup') ?>" style="text-decoration:none;">
                            S'inscrire
                        </a>
                    </div>
                <?php } ?>
            </div>
        </nav>
    </header>
    <main>
        <?= $content ?>
    </main>
    <footer class="mt-5 bg-dark text-light py-5">
        <div class="container">
            <div class="row">
                <div class="col">
                    KVAX by Mathias Billot 2020-2021
                </div>
            </div>
        </div>
    </footer>
    <script>
        console.log('Session:');
        console.log(<?= json_encode($_SESSION) ?>);
    </script>
</body>
</html>