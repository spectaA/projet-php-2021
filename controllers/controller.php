<?php

    require('models/user.php');
    require('models/availabilities.php');
    require('models/centers.php');

    // USERS

    function viewUser() {

        if (isset($_GET['id'])) {
            $userId = $_GET['id'];
            $user = getUser($userId);
            $availabilities = getAvailabilitiesByUserId($userId);
            require('views/pages/user.php');
        } else {
            echo 'Error: aucun identifiant founi';
        }

    }

    function viewUsers() {

        $users = getUsers();
        require('views/pages/users.php');

    }

    function viewMyProfile() {

        $userId = '00e5c034-c3bb-11eb-bdac-c8d9d27b08b0'; // TODO: get user id from session
        $user = getUser($userId);
        $availabilities = getAvailabilitiesByUserId($userId);
        $is_owner = true;
        require('views/pages/user.php');

    }

    // CENTERS

    function viewCenter() {

        if (isset($_GET['id'])) {
            $centerId = $_GET['id'];
            $center = getCenter($centerId);

            $center->count = getAvailabilitiesCount($userId)->count;

            require('views/pages/center.php');
        } else {
            echo 'Error: aucun identifiant founi';
        }

    }

    function viewCenters() {

        $centers = getCenters();
        require('views/pages/centers.php');

    }

    // AVAILABILITIES

    function createAvailability() {

        if ($_POST['submit']) {
            // Post: create
            
            
        } else {
            // Get: view
            
        }

        $userId = '00e5c034-c3bb-11eb-bdac-c8d9d27b08b0'; // TODO: get user id from session


    }

    // STATS

    function viewStats() {

        $centers = getCenters();
        // Get count
        $max_availabilities = 0;
        foreach($centers as $key => $center) {
            $center->count_ever = getAvailabilitiesCountEverByCenterId($center->id);
            $max_availabilities = max(array($max_availabilities, $center->count_ever));
        }

        require('views/pages/stats.php');

    }

?>