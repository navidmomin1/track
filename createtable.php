<?php

    /*
     * Just for developer.
     */

    error_reporting(E_ERROR);
    require_once './db.php';

    $db = getdb();
    if(!$db){
       echo $db->lastErrorMsg();
    } else {
       echo "Opened database successfully\n";
    }
    
    try{
        $db->exec("drop table info;");
        echo "table dropped\n\n";
    } catch (Exception $e){
        echo $e->getMessage();
    }
    
    try{
        $sql ="
          CREATE TABLE INFO
          (URI VARCHAR NOT NULL,
          EMID           TEXT    NOT NULL,
          TS            TEXT     NOT NULL,
          DATA        TEXT
          );";

        $db->exec($sql);
        echo "table created\n\n";
    } catch (Exception $e){
        echo $e->getMessage();
    }
    
    $db->close();
?>