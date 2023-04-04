<?php

namespace Ray\Di\Compiler;

$instance = new \Ray\CakeDbModule\ConnectionProvider(array('driver' => 'Cake\\Database\\Driver\\Sqlite', 'database' => '/Users/tatsuo/MyVendor.Weekday/var/db/todo.sqlite3'));
$isSingleton = true;
return $instance->get();
