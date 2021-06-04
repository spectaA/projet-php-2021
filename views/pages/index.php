<?php
    ob_start();
    $title = 'Accueil';
?>

<div class="container">
    <div class="row">
        <div class="col text-center mb-5">
            <h1>Bienvenue, <?= $logged_user->firstname ?></h1>
            <a class=" mt-4 btn btn-primary" href="<?= redstr('getMyProfile') ?>">Modifier mes disponibilités</a>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-lg-6">
            <div class="rounded py-3 mb-3 text-center bg-light">
                <h3>Centres de vaccination</h3>
            </div>
            <div>
                <?php foreach($centers as $key => $center) { ?>
                    <div class="card text-center mb-3">
                        <div class="card-body">
                            <h4 class="card-title">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eyedropper" viewBox="0 0 16 16">
                                    <path d="M13.354.646a1.207 1.207 0 0 0-1.708 0L8.5 3.793l-.646-.647a.5.5 0 1 0-.708.708L8.293 5l-7.147 7.146A.5.5 0 0 0 1 12.5v1.793l-.854.853a.5.5 0 1 0 .708.707L1.707 15H3.5a.5.5 0 0 0 .354-.146L11 7.707l1.146 1.147a.5.5 0 0 0 .708-.708l-.647-.646 3.147-3.146a1.207 1.207 0 0 0 0-1.708l-2-2zM2 12.707l7-7L10.293 7l-7 7H2v-1.293z"/>
                                </svg>
                                <?= $center->name ?>
                            </h4>
                            <div class="card-text">
                                <div class="mb-2">
                                    <?= $center->address ?>
                                    <?= $center->city.' '.$center->postalCode ?>
                                </div>
                                <div>
                                    <a class="btn btn-outline-primary btn-sm" href="<?= redstr('createAvailability').'&center_id='.$center->id ?>">
                                        Je suis disponible
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="p-5 text-center rounded bg-light">
                <h2 class="mb-5">Soyez prévenu lorsqu'une dose est disponible !</h2>
                <div>
                    <p class="lead mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
                            <path d="M13.485 1.431a1.473 1.473 0 0 1 2.104 2.062l-7.84 9.801a1.473 1.473 0 0 1-2.12.04L.431 8.138a1.473 1.473 0 0 1 2.084-2.083l4.111 4.112 6.82-8.69a.486.486 0 0 1 .04-.045z"/>
                        </svg>
                        Rapide
                    </p>
                    <p class="lead mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
                            <path d="M13.485 1.431a1.473 1.473 0 0 1 2.104 2.062l-7.84 9.801a1.473 1.473 0 0 1-2.12.04L.431 8.138a1.473 1.473 0 0 1 2.084-2.083l4.111 4.112 6.82-8.69a.486.486 0 0 1 .04-.045z"/>
                        </svg>
                        Simple
                    </p>
                    <p class="lead mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
                            <path d="M13.485 1.431a1.473 1.473 0 0 1 2.104 2.062l-7.84 9.801a1.473 1.473 0 0 1-2.12.04L.431 8.138a1.473 1.473 0 0 1 2.084-2.083l4.111 4.112 6.82-8.69a.486.486 0 0 1 .04-.045z"/>
                        </svg>
                        Près de chez vous
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
    $content = ob_get_clean();
    require_once('views/partials/layout.php');
?>