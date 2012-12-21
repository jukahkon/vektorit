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
        $query = self::db()->prepare("INSERT INTO user (email,password,salt,nickname) VALUES(?,?,?,?)");
        $query->bindParam(1,$email);
        $query->bindParam(2,$pass);
        $query->bindParam(3,$salt);
        $query->bindParam(4,$nick);

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
    
 

} // class

?>
