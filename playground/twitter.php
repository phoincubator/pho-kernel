<?php

require "../vendor/autoload.php";

spl_autoload_register(function ($class_name) {
  if(strpos($class_name,"PhoNetworksAutogenerated\\")!==0)
    return;
  $class_name = str_replace("\\", "/", substr($class_name, strlen("PhoNetworksAutogenerated\\")));
  $class_file = __DIR__."/../tests/assets/Twitter/.compiled/".$class_name.".php";
  if(file_exists($class_file))
    include($class_file);
});

$dotenv = new \Dotenv\Dotenv(__DIR__);
$dotenv->load();

$configs = array(
    "services"=>array(
        "database" => ["type" => getenv('DATABASE_TYPE'), "uri" => getenv('DATABASE_URI')],
        "storage" => ["type" => getenv('STORAGE_TYPE'), "uri" =>  getenv("STORAGE_URI")],
        "index" => ["type" => getenv('INDEX_TYPE'), "uri" => getenv('INDEX_URI')]
    )
);

$configs["default_objects"] = [
    "graph" => \PhoNetworksAutogenerated\Twitter::class,
     "founder" => \PhoNetworksAutogenerated\User::class,
];

$kernel = new \Pho\Kernel\Kernel($configs);
$founder = new \PhoNetworksAutogenerated\User($kernel, $kernel->space(), "user1", "1234567");
$kernel->boot($founder);
$user = new \PhoNetworksAutogenerated\User($kernel, $kernel->graph(), "user2", "1234567");
