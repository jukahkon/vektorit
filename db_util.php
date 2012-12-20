<?php

require_once("db_connect.php");

class DbUtil {

    public static function user_exists($email) {
        global $db;

        $query = $db->prepare("SELECT 1 FROM user WHERE email=?");
        $query->bindParam(1,$email);
        $query->execute();

        return $query->rowCount()==0 ? false : true;
    }

    public static function nick_exists($nick) {
        global $db;

        $query = $db->prepare("SELECT 1 FROM user WHERE nickname=?");
        $query->bindParam(1,$nick);
        $query->execute();

        return $query->rowCount()==0 ? false : true;
    }

    public static function add_new_user($email,$nick,$pass,$salt) {
        global $db;

        $query = $db->prepare("INSERT INTO user (email,password,salt,nickname) VALUES(?,?,?,?)");
        $query->bindParam(1,$email);
        $query->bindParam(2,$pass);
        $query->bindParam(3,$salt);
        $query->bindParam(4,$nick);

        $query->execute();
    }

    public static function user_id_by_email($email) {
        global $db;

        $query = $db->prepare("SELECT id FROM user WHERE email=?");
        $query->bindParam(1,$email);
        $query->execute();

        if ($query->rowCount()==1) {
            $row = $query->fetch();
            return $row["id"];
        } else {
            return -1;
        }    
    }

} // class

?>
