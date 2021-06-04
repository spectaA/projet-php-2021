<?php

    class Center {
    
        public static function getAll() {
            try {
                $pdo = getPdo();
                $query = 'SELECT ';
                $query .= '*, ';
                $query .= '(SELECT COUNT(*) FROM availabilities WHERE vc.id = center_id AND (DATE(`date`) = CURDATE())) AS availabilities_today, ';
                $query .= '(SELECT COUNT(*) FROM availabilities WHERE vc.id = center_id AND (DATE(`date`) = (CURDATE() + INTERVAL 1 DAY))) AS availabilities_tomorrow ';
                $query .= 'FROM vaccination_centers AS vc;';
                $req = $pdo->prepare($query);
                $req->execute();
                $center = $req->fetchAll();
        
                return $center;
            } catch (Exception $e) {
                throw new Exception($e->getMessage(), 400);
            }
        }

        public static function getOne($centerId) {
            try {
                $pdo = getPdo();
                $query = 'SELECT ';
                $query .= '*, ';
                $query .= '(SELECT COUNT(*) FROM availabilities WHERE vc.id = center_id AND (DATE(`date`) = CURDATE())) AS availabilities_today, ';
                $query .= '(SELECT COUNT(*) FROM availabilities WHERE vc.id = center_id AND (DATE(`date`) = (CURDATE() + INTERVAL 1 DAY))) AS availabilities_tomorrow ';
                $query .= 'FROM vaccination_centers AS vc WHERE id = ?;';
                $req = $pdo->prepare($query);
                $req->execute(array($centerId));
                $center = $req->fetch();
    
                if (!$center) {
                    throw new Exception("Center $centerId not found", 404);
                }
        
                return $center;
            } catch (Exception $e) {
                throw new Exception($e->getMessage(), 400);
            }
        }
    
        public static function getName($centerId) {
            try {
                $pdo = getPdo();
                $req = $pdo->prepare('SELECT `name` FROM vaccination_centers WHERE id=?;');
                $req->execute(array($centerId));
                $center = $req->fetch();
    
                if (!$center) {
                    throw new Exception("Centre $centerId introuvable", 404);
                }
        
                return $center->name;
            } catch (Exception $e) {
                throw new Exception($e->getMessage(), 400);
            }
        }

        public static function create($name, $city, $postalCode, $address) {
            try {
                $pdo = getPdo();
                $query = "INSERT INTO vaccination_centers (name, city, postalCode, address) VALUES (?, ?, ?, ?);";
                $req = $pdo->prepare($query);
                $req->execute([$name, $city, $postalCode, $address]);
            } catch (Exception $e) {
                throw new Exception($e->getMessage(), 400);
            }
        }

        public static function update($centerId, $name, $city, $postalCode, $address) {
            try {
                $pdo = getPdo();
                $query = "UPDATE vaccination_centers SET name=?, city=?, postalCode=?, address=? WHERE id=?;";
                $req = $pdo->prepare($query);
                $done = $req->execute([$name, $city, $postalCode, $address, $centerId]);
            } catch (Exception $e) {
                throw new Exception($e->getMessage(), 400);
            }
        }

        public static function delete($centerId) {
            try {
                $pdo = getPdo();
                $query = "DELETE FROM vaccination_centers WHERE id=?;";
                $req = $pdo->prepare($query);
                $done = $req->execute([$centerId]);
            } catch (Exception $e) {
                throw new Exception($e->getMessage(), 400);
            }
        }

        // Validate

        public static function validateId($id) {
            return (int) $id;
        }

        public static function validateName($name) {
            if (preg_match('/^[a-z0-9\,\.\-\' ]{0,45}$/i', $name)) {
                return $name;
            }
            throw new Exception('Nom invalide', 400);
        }

        public static function validateCity($city) {
            if (preg_match('/^^[a-z0-9\,\.\-\' ]{0,45}$/i', $city)) {
                return $city;
            }
            throw new Exception('Ville invalide', 400);
        }

        public static function validatePostalCode($postalCode) {
            if (preg_match('/^[0-9]{4}$/i', $postalCode)) {
                return $postalCode;
            }
            throw new Exception('Code postal invalide', 400);
        }

        public static function validateAddress($address) {
            if (preg_match('/^^[a-z0-9\,\.\-\' ]{0,100}$/i', $address)) {
                return $address;
            }
            throw new Exception('Adresse invalide', 400);
        }

    }


?>