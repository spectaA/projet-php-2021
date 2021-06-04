<?php
    ob_start();
    $title = 'Centre '.$center->name;
?>

<div class="container">
    <div class="row">
        <div class="col-12 col-lg-4">
            <div class="card">
                <div class="card-body text-center">
                    <div class="card-title">
                        <div class="mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                                <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
                            </svg>
                        </div>
                        <h2><?= $center->name ?></h2>
                    </div>
                    <div class="card-subtitle mb-2 text-muted"><?= $center->city ?></div>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-compass-fill" viewBox="0 0 16 16">
                            <path d="M15.5 8.516a7.5 7.5 0 1 1-9.462-7.24A1 1 0 0 1 7 0h2a1 1 0 0 1 .962 1.276 7.503 7.503 0 0 1 5.538 7.24zm-3.61-3.905L6.94 7.439 4.11 12.39l4.95-2.828 2.828-4.95z"/>
                        </svg>
                        <?= $center->address ?>
                    </li>
                    <li class="list-group-item">
                        <?= $center->city.' - '.$center->postalCode ?>
                    </li>
                </ul>
                <div class="card-footer text-center">
                    <div class="mb-2">
                        <a class="btn btn-primary" href="<?= redstr('updateCenter').'&id='.$center->id ?>">Modifier</a>
                    </div>
                    <div>
                        <a class="btn btn-outline-danger" href="<?= redstr('deleteCenter').'&id='.$center->id ?>">Supprimer</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-8">
            <h2>Personnes disponibles</i></h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Date</th>
                        <th>Heure</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($availabilities as $key => $availability) { ?>
                        <tr>
                            <td>
                                <a href="<?= redstr('getUser').'&id='.$availability->user_id ?>">
                                    <?= $availability->user_fullname ?>
                                </a>
                            </td>
                            <td><?= date('d/m/y' , strtotime($availability->date)) ?></td>
                            <td><?= date('H:i' , strtotime($availability->date)) ?></td>
                            <td>
                                <a class="text-secondary" href="<?= redstr('updateAvailability').'&id='.$availability->id.'&redirect='.urlencode(redstr('getCenter').'&id='.$center->id) ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                    </svg>
                                </a>
                                <a class="text-danger" href="<?= redstr('deleteAvailability').'&id='.$availability->id ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                        <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <?php if (!$availabilities) { ?>
                <i>Aucune disponibilité</i>
            <?php } ?>
        </div>
    </div>
</div>

<?php
    $content = ob_get_clean();
    require_once('views/partials/layout.php');
?>