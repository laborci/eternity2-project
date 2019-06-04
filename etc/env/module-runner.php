<?php return [
'modules'=>array (
  0 => 
  array (
    'pattern' => ':',
    'handler' => '\\Application\\Module\\Cli\\Module',
  ),
  1 => 
  array (
    'pattern' => 'www.{domain}',
    'handler' => '\\Application\\Module\\Web\\Module',
  ),
  2 => 
  array (
    'pattern' => 'api.{domain}',
    'handler' => '\\Application\\Module\\API\\Module',
  ),
  3 => 
  array (
    'pattern' => 'admin.{domain}',
    'handler' => '\\Application\\Module\\Admin\\Module',
  ),
  4 => 
  array (
    'pattern' => '*',
    'reroute' => 'www.{domain}',
  ),
),
];