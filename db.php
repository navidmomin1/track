<?php

    class MyDB extends SQLite3 {
        function __construct() {
         $this->open('track.db');
      }
   }
   
    function getdb() {
        $db = new MyDB();
        if(!$db) {
           $GLOBALS['log']->error($db->lastErrorMsg());
           return NULL;
        } else {
           return $db;
        }
    }
    
    function query($query) {
        $db = getdb();
        if($db !== NULL){
            $ret = $db->exec($query);
            if(!$ret){
                $GLOBALS['log']->error($db->lastErrorMsg());
            } else {
                $db->close();
                return $ret;
            }
        }
    }
    
    function select($query) {
        $db = getdb();
        if($db !== NULL){
            $ret = $db->query($query);
            $data = [];
            while($row = $ret->fetchArray(SQLITE3_ASSOC) ){
                array_push($data, $row);
            }
            if(!$ret){
                $GLOBALS['log']->error($db->lastErrorMsg());
            } else {
                $db->close();
                return $data;
            }
        }
    }
    