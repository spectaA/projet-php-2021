<?php

    date_default_timezone_set('Europe/Brussels');

    require_once('config.php');
    require_once('controllers/controller.php');

    $controller = new Controller();

    session_start();

    try {

        if (isset($_GET['page'])) {
    
            switch ($_GET['page']) {
                // Auth
                case 'login':
                    $controller->login();
                    break;
                
                case 'logout':
                    isLogged();
                    $controller->logout();
                    break;
                
                // Users
                case 'getUser':
                    isLogged();
                    if (isset($_GET['id'])) {
                        if ($_SESSION['user_id'] != $_GET['id'] && !isset($_SESSION['admin'])) {
                            throw new Exception(null, 401);
                        }
                        $controller->getUser();
                    } else {
                        throw new Exception('Missing ID', 400);
                    }
                    break;
                
                case 'getUsers':
                    isLogged();
                    isAdmin();
                    $controller->getUsers();
                    break;
                
                case 'getMyProfile':
                    isLogged();
                    header('Location: '.redstr('getUser').'&id='.$_SESSION['user_id']);
                    break;

                case 'updateUser':
                    isLogged();
                    $controller->updateUser();
                    break;

                case 'deleteUser':
                    isLogged();
                    isAdmin();
                    $controller->deleteUser();
                    break;
                
                // Centers
                case 'getCenter':
                    isLogged();
                    isAdmin();
                    if (isset($_GET['id'])) {
                        $controller->getCenter();
                    } else {
                        throw new Exception('Missing ID', 400);
                    }
                
                case 'getCenters':
                    isLogged();
                    isAdmin();
                    $controller->getCenters();
                    break;

                case 'createCenter':
                    isLogged();
                    isAdmin();
                    $controller->createCenter();
                    break;

                case 'updateCenter':
                    isLogged();
                    isAdmin();
                    $controller->updateCenter();
                    break;

                case 'deleteCenter':
                    isLogged();
                    isAdmin();
                    $controller->deleteCenter();
                    break;
    
                // Availabilities
                case 'createAvailability':
                    isLogged();
                    $controller->createAvailability();
                    break;
    
                case 'updateAvailability':
                    isLogged();
                    $controller->updateAvailability();
                    break;

                case 'deleteAvailability':
                    isLogged();
                    $controller->deleteAvailability();
                    break;
    
                // Stats
                case 'getStats':
                    isLogged();
                    isAdmin();
                    $controller->getStats();
                    break;
                
                case '':
                    if (isset($_SESSION['user_id'])) {
                        $controller->getIndex();
                    } else {
                        $controller->login();
                    }
                
                default:
                    throw new Exception(null, 404);
            }
    
        } else {
            if (isset($_SESSION['user_id'])) {
                $controller->getIndex();
            } else {
                $controller->login();
            }
        }

    } catch (Exception $e) {
        $code = $e->getCode();
        $msg = $e->getMessage();
        switch ($e->getCode()) {
            case 400:
                http_response_code(400);
                require('views/pages/400.php');
                break;
            case 401:
                http_response_code(401);
                require('views/pages/401.php');
                break;
            case 403:
                http_response_code(403);
                require('views/pages/403.php');
                break;
            case 404:
                http_response_code(404);
                require('views/pages/404.php');
                break;
            default:
                
        }
        exit(0);
    } 
    
    // Check if user is logged and admin before pass to controller
    function isLogged() {
        if (!isset($_SESSION['user_id'])) {
            throw new Exception(null, 401);
        }
    }

    function isAdmin() {
        if (!isset($_SESSION['admin'])) {
            throw new Exception(null, 403);
        }
    }

?>