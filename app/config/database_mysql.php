<?php

return [
     'dsn'     => "your settings",
    'username'        => "your settings",
    'password'        => "your settings",
    'driver_options'  => [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"],
    //'table_prefix'    => "prefix_",
    
    // Display details on what happens
    'verbose' => false,

    // Throw a more verbose exception when failing to connect
    //'debug_connect' => 'true',
];
