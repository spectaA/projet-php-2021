<?php

    function getUsers() {

        $pdo = getPdo();
        $query = 'SELECT ';
        $query .= '*, ';
        $query .= '(SELECT COUNT(*) FROM availabilities WHERE u.id = user_id AND `date` >= NOW()) AS availability_count ';
        $query .= 'FROM users AS u ORDER BY availability_count DESC;';
        $req = $pdo->prepare($query);
        $req->execute();
        $users = $req->fetchAll(PDO::FETCH_OBJ);

        // Compute ages
        foreach($users as $key => $user) {
            $user->age = computeAge($user->birthday);
        }

        return $users;

    }

    function getUser($userId) {

        $pdo = getPdo();
        $query = 'SELECT ';
        $query .= '*, ';
        $query .= '(SELECT COUNT(*) FROM availabilities WHERE u.id = user_id AND `date` >= NOW()) AS availability_count ';
        $query .= 'FROM users AS u WHERE id = ? ORDER BY availability_count DESC;';
        $req = $pdo->prepare($query);
        $req->execute(array($userId));
        $user = $req->fetch(PDO::FETCH_OBJ);

        // Compute age
        $user->age = computeAge($user->birthday);

        return $user;

    }

    function computeAge($date) {
        return date_diff(date_create($date), date_create('now'))->y;
    }

?>