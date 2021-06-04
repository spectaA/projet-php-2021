<?php
    ob_start();
    $title = isset($availability) ? 'Modifier' : 'Créer';
?>

<style>
    form {
        width: 100%;
        max-width: 450px;
        padding: 15px;
        margin: 0 auto;
    }
</style>

<div class="container">
    <div class="row">
        <div class="col">
            <form class="text-center" method="POST" action="<?= isset($availability) ? redstr('updateAvailability') : redstr('createAvailability') ?>">
                <h1 class="h3 mb-3">Disponiblité</h1>
                <?php if(isset($availability)) { ?>
                    <input type="hidden" name="availability_id" value="<?= $availability->id ?>">
                <?php } ?>
                <label>Centre</label>
                <select name="center_id" class="form-select mb-3" required="">
                    <?php foreach($centers as $key=>$center) { ?>
                        <option value="<?= $center->id ?>" <?= (isset($centerId) && $centerId == $center->id) || (isset($availability) && $availability->center_id == $center->id) ? 'selected' : '' ?>>
                            <?= $center->name.' ('.$center->city.' '.$center->postalCode.')' ?>
                        </option>
                    <?php } ?>
                </select>
                <label>Date</label>
                <input id="date-input" name="date" type="date" class="form-control mb-3" min="<?= date('Y-m-d', strtotime('+1 Day')) ?>" max="<?= date('Y-m-d', strtotime('+1 Week')) ?>"
                    required="" value="<?= isset($availability) ? date('Y-m-d', strtotime($availability->date)) : '' ?>">
                <label>Heure</label>
                <select name="time" class="form-select mb-3" required="">
                    <?php foreach(range(7, 20) as $number) { ?>
                        <option value="<?= $number ?>" <?= isset($availability) && date('G', strtotime($availability->date)) == $number ? 'selected' : '' ?>><?= $number.':00' ?></option>
                    <?php } ?>
                </select>
                <button class="btn btn-lg btn-primary btn-block" type="submit"><?= isset($availability) ? 'Modifier' : 'Ajouter' ?></button>
            </form>
        </div>
    </div>
</div>

<script>
    const elmt = document.getElementById("date-input");
    elmt.addEventListener('input', function(e){
        let day = new Date(elmt.value).getUTCDay();
        if([0].includes(day)){
            e.preventDefault();
            this.value = '';
            alert('Aucun rendez-vous le dimanche');
        }
    });
</script>

<?php
    $content = ob_get_clean();
    require_once('views/partials/layout.php');
?>