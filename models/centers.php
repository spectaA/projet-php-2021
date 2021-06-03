<?php

    function getCenter($centerId) {

        $pdo = getPdo();
        $query = 'SELECT ';
        $query .= '*, ';
        $query .= '(SELECT COUNT(*) FROM availabilities WHERE vc.id = center_id AND (DATE(`date`) = CURDATE())) AS availabilities_today, ';
        $query .= '(SELECT COUNT(*) FROM availabilities WHERE vc.id = center_id AND (DATE(`date`) = (CURDATE() + INTERVAL 1 DAY))) AS availabilities_tomorrow ';
        $query .= 'FROM vaccination_centers AS vc WHERE id = ?;';
        $req = $pdo->prepare($query);
        $req->execute(array($centerId));
        $center = $req->fetch(PDO::FETCH_OBJ);

        return $center;

    }

    function getCenterName($centerId) {

        $pdo = getPdo();
        $req = $pdo->prepare('SELECT `name` FROM vaccination_centers WHERE id=?;');
        $req->execute(array($centerId));
        $center = $req->fetch(PDO::FETCH_OBJ);

        return $center->name;

    }

    function getCenters() {

        $pdo = getPdo();
        $query = 'SELECT ';
        $query .= '*, ';
        $query .= '(SELECT COUNT(*) FROM availabilities WHERE vc.id = center_id AND (DATE(`date`) = CURDATE())) AS availabilities_today, ';
        $query .= '(SELECT COUNT(*) FROM availabilities WHERE vc.id = center_id AND (DATE(`date`) = (CURDATE() + INTERVAL 1 DAY))) AS availabilities_tomorrow ';
        $query .= 'FROM vaccination_centers AS vc;';
        $req = $pdo->prepare($query);
        $req->execute();
        $center = $req->fetchAll(PDO::FETCH_OBJ);

        return $center;

    }

?>