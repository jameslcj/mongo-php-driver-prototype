--TEST--
MongoDB\Driver\Manager: mongodb.debug=stderr
--SKIPIF--
<?php require __DIR__ . "/../utils/basic-skipif.inc"; CLEANUP(STANDALONE) ?>
--INI--
mongodb.debug=stderr
--FILE--
<?php
require_once __DIR__ . "/../utils/basic.inc";

$manager = new MongoDB\Driver\Manager(STANDALONE);
$bulk = new MongoDB\Driver\BulkWrite();
$bulk->insert(array('_id' => 1, 'x' => 1));
$result = $manager->executeBulkWrite(NS, $bulk);

ini_set("mongodb.debug", "off");
?>
===DONE===
<?php exit(0); ?>
--EXPECTF--
%a
[%s]     PHONGO: DEBUG   > Creating Manager, phongo-0.%d.%d[%s] - mongoc-1.%s, libbson-1.%s
%a
[%s]     PHONGO: DEBUG   > Connecting to '%s:%d[mongodb://%s:%d]'
%a
===DONE===
