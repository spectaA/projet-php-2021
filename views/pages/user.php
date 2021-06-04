<?php
    ob_start();
    $title = $user->firstname.' '.$user->lastname;
?>

<div class="container">
    <div class="row">
        <div class="col-12 col-lg-4">
            <div class="card">
                <div class="card-body text-center">
                    <div class="card-title">
                        <div class="mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-person-badge-fill" viewBox="0 0 16 16">
                                <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2zm4.5 0a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1h-3zM8 11a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm5 2.755C12.146 12.825 10.623 12 8 12s-4.146.826-5 1.755V14a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-.245z"/>
                            </svg>
                        </div>
                        <h2><?= $user->fullname ?></h2>
                    </div>
                    <div class="card-subtitle mb-2 text-muted"><?= $user->age ?> ans</div>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar-fill" viewBox="0 0 16 16">
                            <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V5h16V4H0V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5z"/>
                        </svg>
                        <?= date('d/m/Y', strtotime($user->birthday)) ?>
                    </li>
                    <li class="list-group-item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope-fill" viewBox="0 0 16 16">
                            <path d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555zM0 4.697v7.104l5.803-3.558L0 4.697zM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586l-1.239-.757zm3.436-.586L16 11.801V4.697l-5.803 3.546z"/>
                        </svg>
                        <a href="mailto:<?= $user->email ?>">
                            <?= $user->email ?>
                        </a>
                    </li>
                    <li class="list-group-item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telephone-fill" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"/>
                        </svg>
                        <a href="tel:<?= $user->phone ?>">
                            <?= $user->phone ?>
                        </a>
                    </li>
                </ul>
                <div class="card-footer text-center">
                    <?php if (isset($is_owner) || isset($_SESSION['admin'])) { ?>
                        <div class="mb-2">
                            <a class="btn btn-primary" href="<?= redstr('updateUser').'&id='.$user->id ?>">Modifier</a>
                        </div>
                    <?php } ?>
                    <?php if (isset($is_owner)) { ?>
                        <div>
                            <a class="btn btn-outline-danger" href="<?= redstr('logout') ?>">Se déconnecter</a>
                        </div>
                    <?php } ?>
                </div>
                <?php if (isset($_SESSION['admin'])) { ?>
                    <div class="card-footer text-center">
                        <div class="mb-2">
                            <a class="btn btn-outline-danger" href="<?= redstr('deleteUser').'&id='.$user->id ?>">Supprimer cet utilisateur</a>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="col-12 col-lg-8">
            <h2>Prochaines disponibilités <i>(<?= $user->availability_count ?>)</i></h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Jour</th>
                        <th>Heure</th>
                        <th>Centre</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($availabilities as $key => $availability) { ?>
                        <tr>
                            <td><?= date('d/m/y' , strtotime($availability->date)) ?></td>
                            <td><?= date('H:i' , strtotime($availability->date)) ?></td>
                            <td>
                                <a href="<?= isset($_SESSION['admin']) ? redstr('getCenter').'&id='.$availability->center_id : redstr('') ?>">
                                    <?= $availability->center_name ?>
                                </a>
                            </td>
                            <!-- For owner or admin only -->
                            <?php if (isset($is_owner) || isset($_SESSION['admin'])) { ?>
                                <td>
                                    <a class="text-secondary" href="<?= redstr('updateAvailability').'&id='.$availability->id.'&redirect='.urlencode(redstr('getUser').'&id='.$user->id) ?>">
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
                            <?php } ?>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <?php if (!$availabilities) { ?>
                <div class="mb-2">
                    <i>Aucune disponibilité</i>
                </div>
            <?php } ?>
            <?php if (isset($is_owner) || isset($_SESSION['admin'])) { ?>
                <div class="text-end">
                    <a class="btn btn-primary" href="<?= redstr('createAvailability').'&user_id='.$user->id.'&redirect='.urlencode(redstr('getUser').'&id='.$user->id) ?>">Ajouter une disponibilité</a>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<?php
    $content = ob_get_clean();
    require_once('views/partials/layout.php');
?>