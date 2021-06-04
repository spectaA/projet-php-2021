<?php

    class User {

        public static function getAll() {
            try {
                $pdo = getPdo();
                $query = 'SELECT ';
                $query .= '*, ';
                $query .= '(SELECT COUNT(*) FROM availabilities WHERE u.id = user_id AND `date` >= NOW()) AS availability_count ';
                $query .= 'FROM users AS u ORDER BY availability_count DESC;';
                $req = $pdo->prepare($query);
                $req->execute();
                $users = $req->fetchAll();
        
                // Computes
                foreach($users as $key => $user) {
                    $user->age = User::computeAge($user->birthday);
                    $user->fullname = User::computeFullname($user);
                }
        
                return $users;
            } catch (Exception $e) {
                throw new Exception($e->getMessage(), 400);
            }
        }
    
        public static function getOne($userId, $field = 'id') {
            try {
                $pdo = getPdo();
                $query = 'SELECT ';
                $query .= '*, ';
                $query .= '(SELECT COUNT(*) FROM availabilities WHERE u.id = user_id AND `date` >= NOW()) AS availability_count ';
                $query .= "FROM users AS u WHERE $field = ? ORDER BY availability_count DESC;";
                $req = $pdo->prepare($query);
                $req->execute(array($userId));
                $user = $req->fetch();
    
                if (!$user) {
                    throw new Exception("Center $userId not found", 404);
                }
        
                // Compute
                $user->age = User::computeAge($user->birthday);
                $user->fullname = User::computeFullname($user);
        
                return $user;
            } catch (Exception $e) {
                throw new Exception($e->getMessage(), 400);
            }
        }

        public static function getByEmail($email) {

            return User::getOne($email, 'email');

        }

        public static function update($userId, $firstname, $lastname, $birthday, $phone, $email, $role) {
            try {
                $pdo = getPdo();
                $query = "UPDATE users SET firstname=?, lastname=?, birthday=?, phone=?, email=?, role=? WHERE id=?;";
                $req = $pdo->prepare($query);
                $done = $req->execute([$firstname, $lastname, $birthday, $phone, $email, $role, $userId]);
            } catch (Exception $e) {
                throw new Exception($e->getMessage(), 400);
            }
        }

        public static function delete($userId) {
            try {
                $pdo = getPdo();
                $query = "DELETE FROM users WHERE id=?;";
                $req = $pdo->prepare($query);
                $done = $req->execute([$userId]);
            } catch (Exception $e) {
                throw new Exception($e->getMessage(), 400);
            }
        }

        // Private
    
        private static function computeAge($date) {
            return date_diff(date_create($date), date_create('now'))->y;
        }

        private static function computeFullname($user) {
            $fullname = $user->firstname.' '.$user->lastname;
            if ($user->role == 'admin') {
                $admin_icon = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-shield-lock-fill" viewBox="0 0 16 16">';
                $admin_icon .= '<path fill-rule="evenodd" d="M8 0c-.69 0-1.843.265-2.928.56-1.11.3-2.229.655-2.887.87a1.54 1.54 0 0 0-1.044 1.262c-.596 4.477.787 7.795 2.465 9.99a11.777 11.777 0 0 0 2.517 2.453c.386.273.744.482 1.048.625.28.132.581.24.829.24s.548-.108.829-.24a7.159 7.159 0 0 0 1.048-.625 11.775 11.775 0 0 0 2.517-2.453c1.678-2.195 3.061-5.513 2.465-9.99a1.541 1.541 0 0 0-1.044-1.263 62.467 62.467 0 0 0-2.887-.87C9.843.266 8.69 0 8 0zm0 5a1.5 1.5 0 0 1 .5 2.915l.385 1.99a.5.5 0 0 1-.491.595h-.788a.5.5 0 0 1-.49-.595l.384-1.99A1.5 1.5 0 0 1 8 5z"/>';
                $admin_icon .= '</svg>';
                $fullname = $admin_icon.' '.$fullname;
            }
            return $fullname;
        }

        // Validate

        public static function validateId($id) {
            if (preg_match('/^[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}$/i', $id)) {
                return $id;
            }
            throw new Exception('Identifiant d\'utilisateur invalide', 400);
        }

        public static function validateNames($name) {
            if (preg_match('/^[a-z]{0,100}$/i', $name)) {
                return $name;
            }
            throw new Exception('Nom invalide', 400);
        }

        public static function validateBirthday($birthday) {
            return date('c', strtotime($birthday));
        }

        public static function validatePhone($phone) {
            if (preg_match('/^[0-9]{1,10}$/i', $phone)) {
                return (int) $phone;
            }
            throw new Exception('Numéro de téléphone invalide', 400);
        }

        public static function validateEmail($email) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return $email;
            }
            throw new Exception('Email invalide', 400);
        }

        public static function validateRole($role) {
            if (is_array($role, ['user', 'admin'])) {
                return $role;
            }
            throw new Exception('Role invalide', 400);
        }

    }


?>