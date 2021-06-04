<?php

    class Availability {

        public static function getAll() {
            try {
                $pdo = getPdo();
                $query = 'SELECT *,';
                $query .= '(SELECT CONCAT(`firstname`, " ", `lastname`) FROM users WHERE a.user_id = id) AS user_fullname, ';
                $query .= '(SELECT `name` FROM vaccination_centers WHERE a.center_id = id) AS center_name ';
                $query .= 'FROM availabilities AS a WHERE `date` >= NOW() ORDER BY `date` ASC;';
                $req = $pdo->prepare($query);
                $req->execute();
                $availabilities = $req->fetchAll();
        
                return $availabilities;
            } catch (Exception $e) {
                throw new Exception($e->getMessage(), 400);
            }
        }

        public static function getOne($availabilityId) {
            try {
                $pdo = getPdo();
                $query = 'SELECT *,';
                $query .= '(SELECT CONCAT(`firstname`, " ", `lastname`) FROM users WHERE a.user_id = id) AS user_fullname, ';
                $query .= '(SELECT `name` FROM vaccination_centers WHERE a.center_id = id) AS center_name ';
                $query .= 'FROM availabilities AS a WHERE id = ? AND `date` >= NOW() ORDER BY `date` ASC;';
                $req = $pdo->prepare($query);
                $req->execute(array($availabilityId));
                $availability = $req->fetch();
    
                if (!$availability) {
                    throw new Exception("Availability $availabilityId not found", 404);
                }
        
                return $availability;
            } catch (Exception $e) {
                throw new Exception($e->getMessage(), 400);
            }
        }
        
        public static function getByUserId($userId) {
            try {
                $pdo = getPdo();
                $query = 'SELECT *,';
                $query .= '(SELECT CONCAT(`firstname`, " ", `lastname`) FROM users WHERE a.user_id = id) AS user_fullname, ';
                $query .= '(SELECT `name` FROM vaccination_centers WHERE a.center_id = id) AS center_name ';
                $query .= 'FROM availabilities AS a WHERE user_id = ? AND `date` >= NOW() ORDER BY `date` ASC;';
                $req = $pdo->prepare($query);
                $req->execute(array($userId));
                $availabilities = $req->fetchAll();
        
                return $availabilities;
            } catch (Exception $e) {
                throw new Exception($e->getMessage(), 400);
            }
        }

        public static function getCountEverByCenterId($centerId) {
            try {
                $pdo = getPdo();
                $query = 'SELECT COUNT(*) AS count_ever ';
                $query .= 'FROM availabilities AS a WHERE center_id = ?;';
                $req = $pdo->prepare($query);
                $req->execute(array($centerId));
                $availability = $req->fetch();
    
                if (!$availability) {
                    throw new Exception("Availability $availabilityId not found", 404);
                }
        
                return $availability->count_ever;
            } catch (Exception $e) {
                throw new Exception($e->getMessage(), 400);
            }
        }

        public static function create($userId, $centerId, $date) {
            try {
                $pdo = getPdo();
                $query = "INSERT INTO availabilities (user_id, center_id, `date`) VALUES (?, ?, ?);";
                $req = $pdo->prepare($query);
                $req->execute([$userId, $centerId, $date]);
            } catch (Exception $e) {
                throw new Exception($e->getMessage(), 400);
            }
        }

        public static function update($availabilityId, $centerId, $date) {
            try {
                $pdo = getPdo();
                $query = "UPDATE availabilities SET center_id=?, `date`=? WHERE id=?;";
                $req = $pdo->prepare($query);
                $done = $req->execute([$centerId, $date, $availabilityId]);
            } catch (Exception $e) {
                throw new Exception($e->getMessage(), 400);
            }
        }

        public static function delete($availabilityId) {
            try {
                $pdo = getPdo();
                $query = "DELETE FROM availabilities WHERE id=?;";
                $req = $pdo->prepare($query);
                $done = $req->execute([$availabilityId]);
            } catch (Exception $e) {
                throw new Exception($e->getMessage(), 400);
            }
        }
        
        // Validation

        public static function validateDateTime($date, $time) {
            $date = date('Y-m-d', strtotime($date));
            $time = (int) $time;

            if(date('w', strtotime($date)) == 0) {
                throw new Exception('Aucun rendez-vous ne peut être pris le dimanche', 400);
            }

            $start = date('Y-m-d', strtotime('+1 Day'));
            $end = date('Y-m-d', strtotime('+1 Week'));

            if ($start <= $date && $date <= $end && $time && $time >= 7 && $time <= 20) {
                return date('c', strtotime("+$time hours", strtotime($date)));
            }
            throw new Exception('Mauvaises valeurs de date et heure', 400);

        }

        public static function validateId($id) {
            if (preg_match('/^[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}$/i', $id)) {
                return $id;
            }
            throw new Exception('Identifiant de disponibilité invalide', 400);
        }

    }

?>