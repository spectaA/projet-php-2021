<?php
    ob_start();
    $title = 'Les centres';
?>

<div class="container">
    <div class="row">
        <div class="col text-center mb-4">
            <h3>Centres de vaccination</h3>
        </div>
    </div>
    <div class="row">
        <table class="table">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Code postal</th>
                    <th>Ville</th>
                    <th>Adresse</th>
                    <th>Personnes disponibles aujourd'hui</th>
                    <th>Personnes disponibles demain</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($centers as $key => $center) { ?>
                    <tr>
                        <td class="fw-bold">
                            <a href="<?= redstr('getCenter').'&id='.$center->id ?>">
                                <?= $center->name ?>
                            </a>
                        </td>
                        <td><?= $center->postalCode ?></td>
                        <td><?= $center->city ?></td>
                        <td><?= $center->address ?></td>
                        <td><?= $center->availabilities_today ?></td>
                        <td><?= $center->availabilities_tomorrow ?></td>
                        <td>
                            <a class="text-secondary" href="<?= redstr('updateCenter').'&id='.$center->id ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                </svg>
                            </a>
                            <a class="text-danger" href="<?= redstr('deleteCenter').'&id='.$center->id ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                    <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                                </svg>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <div class="text-center">
            <a class="btn btn-primary" href="<?= redstr('createCenter') ?>">Ajouter un centre</a>
        </div>
    </div>
</div>

<?php
    $content = ob_get_clean();
    require_once('views/partials/layout.php');
?>