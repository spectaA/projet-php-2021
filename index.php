<?php

    require_once('config.php');
    require_once('controllers/controller.php');
    
    if (isset($_GET['page'])) {

        switch ($_GET['page']) {
            case 'getUser':
                if (isset($_GET['id'])) {
                    viewUser();
                } else {
                    http_response_code(404);
                    echo "Missing ID";
                }
                break;
            
            case 'getUsers':
                viewUsers();
                break;
            
            case 'getMyProfile':
                viewMyProfile();
                break;
            
            case 'getCenter':
                if (isset($_GET['id'])) {
                    viewCenter();
                } else {
                    http_response_code(404);
                    echo "Missing ID";
                }
            
            case 'getCenters':
                viewCenters();
                break;

            case 'getMyProfile':
                viewMyProfile();
                break;

            case 'getStats':
                viewStats();
                break;

            case 'createAvailability':
                createAvailability();
                break;
            
            default:
                http_response_code(404);
                echo "Page introuvable";
        }

    } else {
        require('views/pages/index.php');
    }

?>