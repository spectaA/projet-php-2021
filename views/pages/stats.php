<?php
    ob_start();
    $title = 'Accueil';
?>

<div class="container">
    <div class="row">
        <div class="col text-center">
            <p class="lead">Nombre de disponibilités (depuis toujours) par centre de vaccination</p>
            <div class="mt-5">
                <svg class="chart" width="800" height="<?= count($centers) * 50 ?>" aria-labelledby="Availabilities ever by center" role="img">
                    <title id="title">Availabilities ever by center</title>
                    <g class="bar">
                            <rect width="800" height="<?= count($centers) * 50 ?>" y="0" style="fill-opacity:0;stroke:blue"></rect>
                        </g>
                    <?php
                        $i = 0;
                        $unit_width = 600 / $max_availabilities;
                        foreach($centers as $key => $center) {
                            $y = (50 * $i) + 7.5;
                            $width = ($unit_width * $center->count_ever) + 2;
                            $label_x = $width + 5;
                            $label_y = $y + 15;
                            $i++;
                    ?>
                        <g class="bar">
                            <rect width="<?= $width ?>" height="35" y="<?= $y ?>" style="fill:blue;"></rect>
                            <text x="<?= $label_x ?>" y="<?= $label_y ?>" dy=".35em"><?= $center->count_ever.' - '.$center->name ?></text>
                        </g>
                    <?php } ?>
                </svg>
            </div>
        </div>
    </div>
</div>

<?php
    $content = ob_get_clean();
    require_once('views/partials/layout.php');
?>