<?php
    
    define("host" , "localhost");
    define("user","root");
    define("password","new_password");
    define("db","bank8");

    class Db {

        public function connect(){


            try{
                $dsn= "mysql:host=" .host .";dbname=" . db;
             return new PDO($dsn,user,password);
            }catch(PDOException $e){
                die("Error:" . $e->getcode());
        
            }
        }
    }

?>