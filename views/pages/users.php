<?php
    ob_start();
    $title = 'Utilisateurs';
?>

<div class="container">
    <div class="row">
        <div class="col text-center mb-4">
            <h3>Utilisateurs</h3>
        </div>
    </div>
    <div class="row">
        <table class="table">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Age</th>
                    <th>Disponibilités à venir</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($users as $key => $user) { ?>
                    <tr>
                        <td>
                            <a href="<?= redstr('getUser').'&id='.$user->id ?>">
                                <?= $user->fullname ?>
                            </a>
                        </td>
                        <td><?= $user->age ?> ans</td>
                        <td><?= $user->availability_count ?></td>
                        <td>
                            <a href="<?= redstr('getUser').'&id='.$user->id ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-square-fill" viewBox="0 0 16 16">
                                    <path d="M0 14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2a2 2 0 0 0-2 2v12zm4.5-6.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5a.5.5 0 0 1 0-1z"/>
                                </svg>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<?php
    $content = ob_get_clean();
    require_once('views/partials/layout.php');
?>