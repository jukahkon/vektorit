<?php

class DbUtil {
    
    public static function db() {
        static $db_connection = null;
        
        if ($db_connection == null) {
            try {
                $db_connection = new PDO("mysql:host=localhost;dbname=vektorit", "vektorit", "vektorit");
                $db_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (Exception $e) {
                error_log("Cannot connect to database: $e");
            }
        }
        
        return $db_connection;
    }

    public static function user_exists($email) {
        $query = self::db()->prepare("SELECT 1 FROM user WHERE email=?");
        $query->bindParam(1,$email);
        $query->execute();

        return $query->rowCount()==0 ? false : true;
    }

    public static function nick_exists($nick) {
        $query = self::db()->prepare("SELECT 1 FROM user WHERE nickname=?");
        $query->bindParam(1,$nick);
        $query->execute();

        return $query->rowCount()==0 ? false : true;
    }

    public static function add_new_user($email,$nick,$pass,$salt) {
        error_log("add_new_user()");
        $query = self::db()->prepare("INSERT INTO user (email,password,salt,nickname) VALUES(?,?,?,?)");
        $query->bindParam(1,$email);
        $query->bindParam(2,$pass);
        $query->bindParam(3,$salt);
        $query->bindParam(4,$nick);

        $query->execute();
    }
    
    public static function remove_all_users() {
        error_log("remove_all_users()");
        $query = self::db()->prepare("DELETE FROM user");
        $query->execute();        
    }

    public static function user_id_by_email($email) {
        $query = self::db()->prepare("SELECT id FROM user WHERE email=?");
        $query->bindParam(1,$email);
        $query->execute();

        if ($query->rowCount()==1) {
            $row = $query->fetch();
            return $row["id"];
        } else {
            return 0;
        }    
    }
    
    public static function nickname($user) {
        $query = self::db()->prepare("SELECT nickname FROM user WHERE id=?");
        $query->bindParam(1,$user);
        $query->execute();
        $row = $query->fetch();
        return $row["nickname"];
    }
    
    public static function user_autenthicate($email,$pass) {
        $query = self::db()->prepare("SELECT password,salt FROM user WHERE email=?");
        $query->bindParam(1,$email);
        $query->execute();

        if ($query->rowCount()==1) {
            $row = $query->fetch();
            $password = $row["password"];
            $salt = $row["salt"];
            
            $hashedPass = sha1($pass . $salt);
            
            return $password == $hashedPass ? true : false;
            
        } else {
            return false;
        }    
    }
    
    public static function update_trip($user,$distance,$date) {
        // add new or update existing
        $query = self::db()->prepare("SELECT id FROM trip WHERE user=? AND date=?");
        $query->bindParam(1,$user);
        $query->bindParam(2,$date);
        $query->execute();

        if ($query->rowCount()==1) {
            $row = $query->fetch();
            $id = $row["id"];
            $query = self::db()->prepare("UPDATE trip SET distance=? WHERE id=?");
            $query->bindParam(1,$distance);
            $query->bindParam(2,$id);
            $query->execute();            
        } else {
            $query = self::db()->prepare("INSERT INTO trip (user,distance,date) VALUES(?,?,?)");
            $query->bindParam(1,$user);
            $query->bindParam(2,$distance);
            $query->bindParam(3,$date);
            $query->execute();
        }
    }
    
    public static function get_trips($user) {
        $query = self::db()->prepare("SELECT * FROM trip WHERE user=? ORDER BY date DESC");
        $query->bindParam(1,$user);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public static function remove_all_trips() {
        error_log("remove_all_trips()");
        $query = self::db()->prepare("DELETE FROM trip");
        $query->execute();        
    }
    
    public static function get_users() {
        $query = self::db()->prepare("SELECT id FROM user");
        $query->execute();
        return $query->fetchAll();
    }
    
    public static function get_total_distance($user) {
        $query = self::db()->prepare("SELECT SUM(distance) AS total FROM trip WHERE user=?");
        $query->bindParam(1,$user);
        $query->execute();
        
        if ($query->rowCount()==1) {
            $row = $query->fetch();
            return $row["total"] ? $row["total"] : 0;
        } else {
            return 0;
        } 
    }
    
    public static function get_total_distance_by_date($user, $date) {
        $query = self::db()->prepare("SELECT SUM(distance) AS total FROM trip WHERE user=? AND date <= ?");
        $query->bindParam(1,$user);
        $query->bindParam(2,$date);
        $query->execute();
        
        if ($query->rowCount()==1) {
            $row = $query->fetch();
            return $row["total"] ? $row["total"] : 0;
        } else {
            return 0;
        } 
    }
    
    public static function get_trip_distance_by_date($user, $date) {
        $query = self::db()->prepare("SELECT distance FROM trip WHERE user=? AND date=?");
        $query->bindParam(1,$user);
        $query->bindParam(2,$date);
        $query->execute();
        $row = $query->fetch();
        return $row["distance"] ? $row["distance"] : 0;
    }
    
    public static function find_step_for_distance($distance) {
        $query = self::db()->prepare("SELECT id FROM step WHERE distance >= ? LIMIT 1");
        $query->bindParam(1,$distance);
        $query->execute();
        $row = $query->fetch();
        return $row["id"] ? $row["id"] : 0;
    }
    
    public static function update_location($user, $step) {
        // add new or update existing
        $query = self::db()->prepare("SELECT id FROM location WHERE user=?");
        $query->bindParam(1,$user);
        $query->execute();

        if ($query->rowCount()==1) {
            $row = $query->fetch();
            $id = $row["id"];
            $query = self::db()->prepare("UPDATE location SET step=? WHERE id=?");
            $query->bindParam(1,$step);
            $query->bindParam(2,$id);
            $query->execute();
        } else {
            $query = self::db()->prepare("INSERT INTO location (user,step) VALUES(?,?)");
            $query->bindParam(1,$user);
            $query->bindParam(2,$step);
            $query->execute();
        }
    }
    
    public static function get_current_location($user) {
        $query = self::db()->prepare("SELECT step.lat, step.lng, step.heading FROM location INNER JOIN step ON location.step=step.id WHERE user=?");
        $query->bindParam(1,$user);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }
    
    public static function get_route_id(/* name */) {
        $query = self::db()->prepare("SELECT id FROM route LIMIT 1");
        $query->execute();
        $row = $query->fetch();
        return $row["id"] ? $row["id"] : 0;
    }
    
    public static function get_route_length(/* name */) {
        $query = self::db()->prepare("SELECT length FROM route LIMIT 1");
        $query->execute();
        $row = $query->fetch();
        return $row["length"];
    }
    
    public static function get_route_waypoints($route) {
        $query = self::db()->prepare(
            "SELECT lat,lng,distance FROM step WHERE id IN
                ((SELECT id FROM step ORDER BY distance LIMIT 1),
                 (SELECT id FROM step ORDER BY distance DESC LIMIT 1)) ORDER BY distance");
        $query->bindParam(1,$route);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public static function get_trip_steps($route,$fromDistance,$toDistance) {
        $query = self::db()->prepare("SELECT lat,lng,distance FROM step 
                                      WHERE route=? AND distance BETWEEN ? AND ?");
        $query->bindParam(1,$route);
        $query->bindParam(2,$fromDistance);
        $query->bindParam(3,$toDistance);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    
} // class

?>
