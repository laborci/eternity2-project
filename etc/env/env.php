<?php return [
'domain'=>'e2.test',
'timezone'=>'Europe/Budapest',
'output-buffering'=>true,
'database'=>array (
  'default' => 
  array (
    'scheme' => 'mysql',
    'host' => 'mariadb',
    'port' => 3306,
    'user' => 'root',
    'password' => 'root',
    'database' => 'mik_login',
    'charset' => 'utf8',
  ),
),
'boot-sequence'=>array (
  0 => '\\Application\\Service\\ServiceRegistry',
  1 => '\\Eternity2\\System\\Module\\ModuleRunner',
),
];