<?php

    require('models/user.php');
    require('models/availability.php');
    require('models/center.php');

    class Controller {

        function getLoggedUser() {

            $userId = $_SESSION['user_id'];
            return User::getOne($userId);

        }

        // INDEX

        function getIndex() {

            $logged_user = $this->getLoggedUser();
            $centers = Center::getAll();
            require('views/pages/index.php');

        }

        // AUTH

        function login() {

            if (isset($_POST['email']) && isset($_POST['password'])) {
                // Log in

                $email = $_POST['email'];
                $password = $_POST['password'];

                $user = User::getByEmail($email);
                if (!$user) {
                    http_response_code(404);
                    $bad_credentials = true;
                    require('views/pages/login.php');
                    exit(0);
                }

                if ($user->role == 'admin') {
                    $_SESSION['admin'] = true;
                }
                $_SESSION['user_id'] = $user->id;
                $_SESSION['user_fullname'] = $user->fullname;

                if (isset($_GET['redirect'])) {
                    header('Location: '.redstr($_GET['redirect']));
                } else {
                    header('Location: '.redstr(''));
                }

            } else {

                require('views/pages/login.php');

            }

        }

        function logout() {
            
            unset($_SESSION['user_id']);
            unset($_SESSION['admin']);
            session_destroy();
            header('Location: '.redstr(''));
            exit(0);
        }

        // USERS
    
        function getUser() {
    
            if (isset($_GET['id'])) {
                $userId = $_GET['id'];
                $user = User::getOne($userId);
                $availabilities = Availability::getByUserId($userId);
                if ($_SESSION['user_id'] == $userId) {
                    $is_owner = true;
                }
                require('views/pages/user.php');
            } else {
                echo 'Error: aucun identifiant founi';
            }
    
        }
    
        function getUsers() {
    
            $users = User::getAll();
            require('views/pages/users.php');
    
        }

        function updateUser() {

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Post: create
                if (isset($_POST['user_id']) && isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['birthday']) && isset($_POST['phone'])
                        && isset($_POST['email'])) {
                    
                    $userId = User::validateId($_POST['user_id']);
                    $firstname = User::validateNames($_POST['firstname']);
                    $lastname = User::validateNames($_POST['lastname']);
                    $birthday = User::validateBirthday($_POST['birthday']);
                    $phone = User::validatePhone($_POST['phone']);
                    $email = User::validateEmail($_POST['email']);
                    
                    if (isset($_POST['role'])) {
                        $role = $_POST['role'];
                    } else {
                        $user = User::getOne($userId);
                        $role = $user->role;
                    }

                    User::update($userId, $firstname, $lastname, $birthday, $phone, $email, $role);
                    header('Location: '.redstr('getUser').'&id='.$userId);
                } else {
                    throw new Exception(null, 404);
                }
            } else if (isset($_GET['id'])) {
                // Get: view
                $user = User::getOne($_GET['id']);
                require('views/pages/updateUser.php');
            } else {
                throw new Exception('Missing ID', 404);
            }

        }

        function deleteUser() {

            if (isset($_GET['id'])) {
                if ($_GET['id'] == $_SESSION['user_id'] || isset($_SESSION['admin'])) {
                    User::delete($_GET['id']);
                    header('Location: '.redstr('getUsers'));
                } else {
                    throw new Exception(null, 401);
                }
            } else {
                throw new Exception('Missing ID', 404);
            }

        }
    
        // CENTERS
    
        function getCenter() {
    
            if (isset($_GET['id'])) {

                $centerId = $_GET['id'];
                $center = Center::getOne($centerId);   
                $availabilities = Availability::getAll();
                require('views/pages/center.php');

            } else {
                echo 'Error: aucun identifiant founi';
            }
    
        }
    
        function getCenters() {
    
            $centers = Center::getAll();
            require('views/pages/centers.php');
    
        }

        function createCenter() {

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Post: create
                if (isset($_POST['name']) && isset($_POST['city']) && isset($_POST['postalCode']) && isset($_POST['address'])) {
                    
                    $centerId = Center::validateId($_POST['center_id']);
                    $name = Center::validateName($_POST['name']);
                    $city = Center::validateCity($_POST['city']);
                    $postalCode = Center::validatePostalCode($_POST['postalCode']);
                    $address = Center::validateAddress($_POST['address']);

                    Center::create($name, $city, $postalCode, $address);
                    header('Location: '.redstr('getCenters'));
                } else {
                    throw new Exception(null, 404);
                }
            } else {
                // Get: view
                require('views/pages/updateCenter.php');
            }

        }

        function updateCenter() {

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Post: create
                if (isset($_POST['center_id']) && isset($_POST['name']) && isset($_POST['city']) && isset($_POST['postalCode']) && isset($_POST['address'])) {
                    
                    $centerId = Center::validateId($_POST['center_id']);
                    $name = Center::validateName($_POST['name']);
                    $city = Center::validateCity($_POST['city']);
                    $postalCode = Center::validatePostalCode($_POST['postalCode']);
                    $address = Center::validateAddress($_POST['address']);

                    Center::update($centerId, $name, $city, $postalCode, $address);
                    header('Location: '.redstr('getCenter').'&id='.$centerId);
                } else {
                    throw new Exception(null, 404);
                }
            } else if (isset($_GET['id'])) {
                // Get: view
                $center = Center::getOne($_GET['id']);
                require('views/pages/updateCenter.php');
            } else {
                throw new Exception('Missing ID', 404);
            }

        }

        function deleteCenter() {

            if (isset($_GET['id'])) {
                if (isset($_SESSION['admin'])) {
                    Center::delete($_GET['id']);
                    header('Location: '.redstr('getCenters'));
                } else {
                    throw new Exception(null, 401);
                }
            } else {
                throw new Exception('Missing ID', 404);
            }

        }
    
        // AVAILABILITIES

        function createAvailability() {

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Post: create
                if (isset($_POST['center_id']) && isset($_POST['date']) && isset($_POST['time'])) {
                    parse_str($_SERVER['HTTP_REFERER'], $referer);
                    if (isset($referer['user_id']) && ($referer['user_id'] == $_SESSION['user_id'] || isset($_SESSION['admin']))) {
                        $userId = $referer['user_id'];
                        $centerId = Center::validateId($_POST['center_id']);
                        $date = Availability::validateDateTime($_POST['date'], $_POST['time']);
                        Availability::create($userId, $centerId, $date);
                        $url = parse_str($_SERVER['HTTP_REFERER'], $referer);
                        $url = $referer['redirect'];
                        header("Location: $url");
                    } else {
                        throw new Exception('Identifiant utilisateur illégal', 401);
                    }
                } else {
                    throw new Exception(null, 404);
                }
            } else {
                // Get: view
                $centers = Center::getAll();
                if (isset($_GET['center_id'])) {
                    $centerId = $_GET['center_id'];
                }
                require('views/pages/createUpdateAvailability.php');
            }

        }
    
        function updateAvailability() {
    
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Post: create
                if (isset($_POST['center_id']) && isset($_POST['date']) && isset($_POST['time']) && isset($_POST['availability_id'])) {
                    $availabilityId = Availability::validateId($_POST['availability_id']);
                    $centerId = Center::validateId($_POST['center_id']);
                    $date = Availability::validateDateTime($_POST['date'], $_POST['time']);
                    Availability::update($availabilityId, $centerId, $date);
                    $url = parse_str($_SERVER['HTTP_REFERER'], $referer);
                    $url = $referer['redirect'];
                    header("Location: $url");
                } else {
                    throw new Exception(null, 404);
                }
            } else if (isset($_GET['id'])) {
                // Get: view
                $availability = Availability::getOne($_GET['id']);
                $centers = Center::getAll();
                if (isset($_GET['center_id'])) {
                    $centerId = $_GET['center_id'];
                }
                require('views/pages/createUpdateAvailability.php');
            } else {
                throw new Exception('Missing ID', 404);
            }
    
        }

        function deleteAvailability() {

            if (isset($_GET['id'])) {

                $availability = Availability::getOne($_GET['id']);
                if ($availability->user_id == $_SESSION['user_id'] || isset($_SESSION['admin'])) {
                    Availability::delete($_GET['id']);
                    header('Location: '.$_SERVER['HTTP_REFERER']);
                } else {
                    throw new Exception(null, 401);
                }
            } else {
                throw new Exception('Missing ID', 404);
            }

        }
    
        // STATS
    
        function getStats() {
    
            $centers = Center::getAll();
            // Get count
            $max_availabilities = 0;
            foreach($centers as $key => $center) {
                $center->count_ever = Availability::getCountEverByCenterId($center->id);
                $max_availabilities = max(array($max_availabilities, $center->count_ever));
            }
    
            require('views/pages/stats.php');
    
        }

    }

?>