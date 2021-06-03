<?php
    ob_start();
    $title = 'User '.$user->firstname.' '.$user->lastname;
?>

<div class="container">
    <div class="row">
        <div class="col-12 col-lg-4">
            <div class="card">
                <div class="card-body text-center">
                    <div class="card-title">
                        <h2><?= $user->firstname.' '.$user->lastname ?></h2>
                    </div>
                    <div class="card-subtitle mb-2 text-muted"><?= $user->age ?> ans</div>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar-fill" viewBox="0 0 16 16">
                            <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V5h16V4H0V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5z"/>
                        </svg>
                        <?= $user->birthday ?>
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
                <?php if (isset($is_owner)) { ?>
                    <div class="card-footer text-center">
                        <a class="btn btn-primary" href="<?= redstr('updateUser').'&id='.$user->id ?>">Modifier mon profile</a>
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
                                <a href="<?= redstr('getCenter').'&id='.$availability->center_id ?>">
                                    <?= $availability->center_name ?>
                                </a>
                            </td>
                            <!-- For owner or admin only -->
                            <?php if (isset($is_owner) || isset($is_admin)) { ?>
                                <td>
                                    <a href="<?= redstr('deleteAvailability').'&id='.$availability->id ?>">
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
                <i>Aucune disponibilité</i>
            <?php } ?>
        </div>
    </div>
</div>

<?php
    $content = ob_get_clean();
    require_once('views/partials/layout.php');
?>