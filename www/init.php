<?php 
    session_start();
    require_once __DIR__ . '/../config/db_config.php';
    try{
        $db_connect = new PDO("mysql:host=".db_host.";dbname=".db_name.";charset=utf8",db_root,db_pw);
        $db_connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e){
        echo "". $e->getMessage();
        die("DB connection error : ". $e->getMessage());
    }
    
    if (isset($_SESSION["userid"])){
        
    }
?>