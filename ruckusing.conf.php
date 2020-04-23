<?php
//----------------------------
// DATABASE CONFIGURATION
//----------------------------
/*
Valid types (adapters) are Postgres & MySQL:
'type' must be one of: 'pgsql' or 'mysql'
*/
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
return array(
    'db' => array(
        'development' => array(
            'type'      => getenv('DB_TYPE'),
            'host'      => getenv('DB_HOST'),
            'port'      => getenv('DB_PORT'),
            'database'  => getenv('DB_NAME'),
            'user'      => getenv('DB_USER'),
            'password'  => getenv('DB_PASS'),
        ),
//        'test'  => array(
//            'type'  => 'mysql',
//            'host'  => 'localhost',
//            'port'  => 3306,
//            'database'  => 'php_migrations_example_test',
//            'user'  => 'root',
//            'password'  => 'root'
//        )
    ),
    'migrations_dir' => RUCKUSING_WORKING_BASE . '/db/migrations',
    'db_dir' => RUCKUSING_WORKING_BASE . '/db/utility',
    'log_dir' => RUCKUSING_WORKING_BASE . '/db/logs'
);
?>