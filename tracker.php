<?php
    error_reporting(E_ERROR);
    require_once './logger.php';
    require_once './db.php';
    
    $db = getdb();
    if($db !== NULL){
        
        //token generation
         if(isset($_REQUEST['emid'])){
            $em = $_REQUEST['emid'];
            $ts = date("Y-m-d H:i:s");
            $data = json_encode($_SERVER);
            
            $uri = $_SERVER['HTTP_HOST'];
            $query = "insert into info values ('" . $uri . "','" . $em . "','" . $ts . "','" . $data . "');";
            query($query);
         }
         else{
             $log->info("field emid should be present");
         }
         
         //for display token info
         if(!empty($_REQUEST['token']) ){
             
            echo json_encode(select("select * from info where uri = '" . $_REQUEST['token'] . "';"));
         }
         else{
             $log->info("token is mandatory to display data");
         }
         
         //foreach token, display stats
         if( isset($_REQUEST['from']) && isset($_REQUEST['to']) && strlen($_REQUEST['from']) === 19 && strlen($_REQUEST['to']) === 19 ){
             $query_count_nt_uniq = "select uri, count(*) from info where ts between ' " . $_REQUEST['from'] . "' and '" . $_REQUEST['to'] . "' group by URI;";
             echo "Count Open Per Token = " . json_encode(select($query_count_nt_uniq)) . "\n\n";
             $query_count_uniq = "select uri, count(distinct TS) from info where ts between ' " . $_REQUEST['from'] . "' and '" . $_REQUEST['to'] . "' group by URI;";
             echo "Count (Unique) Open Per Token = " . json_encode(select($query_count_uniq)) . "\n\n";
         }
         else{
             $log->info("for stats: from=YYYY-MM-DD HH:MM:SS to=YYYY-MM-DD HH:MM:SS, should be present\n");
         }
         
         //for help
         if(!isset($_REQUEST['emid']) && !isset($_REQUEST['token']) && !isset($_REQUEST['stats'])){
             
             $info = "for stats: from=YYYY-MM-DD HH:MM:SS to=YYYY-MM-DD HH:MM:SS, should be present\n";
             $info .= "for display info on token: token, should be present\n";
             $info .=  "for token generation: emid, should be present\n";
             $log->info($info);
         }
         
    }
     
