<?php
    ob_start();
    $title = 'Accueil';
?>

<!-- TODO -->
Index

<?php
    $content = ob_get_clean();
    require_once('views/partials/layout.php');
?>