<?php

return [
    // Local
    // Set up details on how to connect to the database
    'dsn'     => "mysql:host=localhost;dbname=test;",
    'username'        => "root",
    'password'        => "Loggain12",
    'driver_options'  => [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"],
    'table_prefix'    => "wgtotw_",
    //
    
    /* BTH
     'dsn'     => "mysql:host=blu-ray.student.bth.se;dbname=dasv15;",
    'username'        => "dasv15",
    'password'        => "rW@5Ku5}",
    'driver_options'  => [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"],
    'table_prefix'    => "kmom04_",
    */
    
    // Display details on what happens
    'verbose' => false,

    // Throw a more verbose exception when failing to connect
    //'debug_connect' => 'true',
];
