<?php
    error_reporting(E_ERROR);
    require_once './logger.php';
    require_once './db.php';
    
    $db = getdb();
    if($db !== NULL){
         if(isset($_REQUEST['emid'])){
            $em = $_REQUEST['emid'];
            $ts = date("Y-m-d H:i:s");
            $data = json_encode($_SERVER);
            
            $uri = $_SERVER['HTTP_HOST'];
            $query = "insert into info values ('" . $uri . "','" . $em . "','" . $ts . "','" . $data . "');";
            query($query);
         }
         
         else if(isset($_REQUEST['token'])){
             
            echo json_encode(select("select * from info where uri = '" . $_REQUEST['token'] . "';"));
         }
         
         else if(isset($_REQUEST['stats']) && $_REQUEST['stats'] === 'Y' && isset($_REQUEST['from']) && isset($_REQUEST['to'])){
             $query_count_nt_uniq = "select uri, count(*) from info where ts between ' " . $_REQUEST['from'] . "' and '" . $_REQUEST['to'] . "' group by URI;";
             echo "Count Open Per Token = " . json_encode(select($query_count_nt_uniq)) . "\n\n";
             $query_count_uniq = "select uri, count(distinct TS) from info where ts between ' " . $_REQUEST['from'] . "' and '" . $_REQUEST['to'] . "' group by URI;";
             echo "Count (Unique) Open Per Token = " . json_encode(select($query_count_uniq)) . "\n\n";
         }else{
             
             $info = "for stats: stats=Y, from=YYYY-MM-DD HH:MM:SS to=YYYY-MM-DD HH:MM:SS, should be present\n";
             $info .= "for display info on token: token, should be present\n";
             $info .=  "for token generation: emid, should be present\n";
             $log->info($info);
         }
         
    }
     
