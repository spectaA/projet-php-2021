<?php

    function getAvailabilitiesByUserId($userId) {

        $pdo = getPdo();
        $query = 'SELECT *,';
        $query .= '(SELECT `name` FROM vaccination_centers WHERE a.center_id = id) AS center_name ';
        $query .= 'FROM availabilities AS a WHERE user_id = ? AND `date` >= NOW() ORDER BY `date` ASC;';
        $req = $pdo->prepare($query);
        $req->execute(array($userId));
        $availabilities = $req->fetchAll(PDO::FETCH_OBJ);

        return $availabilities;

    }

    function getAvailabilitiesCountEverByCenterId($centerId) {

        $pdo = getPdo();
        $query = 'SELECT COUNT(*) AS count_ever ';
        $query .= 'FROM availabilities AS a WHERE center_id = ?;';
        $req = $pdo->prepare($query);
        $req->execute(array($centerId));
        $availability = $req->fetch(PDO::FETCH_OBJ);

        return $availability->count_ever;

    }

?>