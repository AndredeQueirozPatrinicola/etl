<?php

require "vendor/autoload.php";

use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;

$capsule->addConnection([

   "driver"    => $_ENV['DB_CONNECTION'],
   "host"      => $_ENV['DB_HOST'],
   "database"  => $_ENV['DB_DATABASE'],
   "username"  => $_ENV['DB_USERNAME'],
   "password"  => $_ENV['DB_PASSWORD'],
   "charset"   => "utf8",
   "collation" => "utf8_unicode_ci",
   "prefix"    => "",

]);

// Make this Capsule instance available globally.
$capsule->setAsGlobal();

// Setup the Eloquent ORM.
$capsule->bootEloquent();

// Enable getQueryLog method;
$capsule::connection()->enableQueryLog();