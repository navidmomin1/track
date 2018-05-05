<?php

    require_once './vendor/autoload.php';
    
    use Monolog\Logger;
    use Monolog\Handler\StreamHandler;
    use Monolog\Handler\FirePHPHandler;

    
    $log = new Logger('tracker_logger');
    $log->pushHandler(new StreamHandler(__DIR__.'/tracker_log.log', Logger::DEBUG));
    $log->pushHandler(new FirePHPHandler());
