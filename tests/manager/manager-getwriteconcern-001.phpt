--TEST--
MongoDB\Driver\Manager::getWriteConcern()
--SKIPIF--
<?php require __DIR__ . "/../utils/basic-skipif.inc"?>
--FILE--
<?php
require_once __DIR__ . "/../utils/basic.inc";

$tests = array(
    array(STANDALONE, array()),
    array(STANDALONE . '/?w=1', array()),
    array(STANDALONE . '/?w=majority', array()),
    array(STANDALONE, array('w' => 1, 'journal' => true)),
    array(STANDALONE, array('w' => 'majority', 'journal' => true)),
    array(STANDALONE . '/?w=majority&journal=true', array('w' => 1, 'journal' => false)),
    // wtimeoutms does not get applied unless w > 1, w = majority, or tag sets are used
    array(STANDALONE . '/?wtimeoutms=1000', array()),
    array(STANDALONE, array('wtimeoutms' => 1000)),
    array(STANDALONE . '/?w=2', array('wtimeoutms' => 1000)),
    array(STANDALONE . '/?w=majority', array('wtimeoutms' => 1000)),
    array(STANDALONE . '/?w=customTagSet', array('wtimeoutms' => 1000)),
);

foreach ($tests as $i => $test) {
    list($uri, $options) = $test;

    $manager = new MongoDB\Driver\Manager($uri, $options);
    var_dump($manager->getWriteConcern());

    // Test for !return_value_used
    $manager->getWriteConcern();
}

?>
===DONE===
<?php exit(0); ?>
--EXPECT--
array(4) {
  ["wmajority"]=>
  bool(false)
  ["wtimeout"]=>
  int(0)
  ["fsync"]=>
  NULL
  ["journal"]=>
  NULL
}
array(5) {
  ["w"]=>
  int(1)
  ["wmajority"]=>
  bool(false)
  ["wtimeout"]=>
  int(0)
  ["fsync"]=>
  NULL
  ["journal"]=>
  NULL
}
array(5) {
  ["w"]=>
  string(8) "majority"
  ["wmajority"]=>
  bool(true)
  ["wtimeout"]=>
  int(0)
  ["fsync"]=>
  NULL
  ["journal"]=>
  NULL
}
array(5) {
  ["w"]=>
  int(1)
  ["wmajority"]=>
  bool(false)
  ["wtimeout"]=>
  int(0)
  ["fsync"]=>
  NULL
  ["journal"]=>
  bool(true)
}
array(5) {
  ["w"]=>
  string(8) "majority"
  ["wmajority"]=>
  bool(true)
  ["wtimeout"]=>
  int(0)
  ["fsync"]=>
  NULL
  ["journal"]=>
  bool(true)
}
array(5) {
  ["w"]=>
  int(1)
  ["wmajority"]=>
  bool(false)
  ["wtimeout"]=>
  int(0)
  ["fsync"]=>
  NULL
  ["journal"]=>
  bool(false)
}
array(4) {
  ["wmajority"]=>
  bool(false)
  ["wtimeout"]=>
  int(0)
  ["fsync"]=>
  NULL
  ["journal"]=>
  NULL
}
array(4) {
  ["wmajority"]=>
  bool(false)
  ["wtimeout"]=>
  int(0)
  ["fsync"]=>
  NULL
  ["journal"]=>
  NULL
}
array(5) {
  ["w"]=>
  int(2)
  ["wmajority"]=>
  bool(false)
  ["wtimeout"]=>
  int(1000)
  ["fsync"]=>
  NULL
  ["journal"]=>
  NULL
}
array(5) {
  ["w"]=>
  string(8) "majority"
  ["wmajority"]=>
  bool(true)
  ["wtimeout"]=>
  int(1000)
  ["fsync"]=>
  NULL
  ["journal"]=>
  NULL
}
array(5) {
  ["w"]=>
  string(12) "customTagSet"
  ["wmajority"]=>
  bool(false)
  ["wtimeout"]=>
  int(1000)
  ["fsync"]=>
  NULL
  ["journal"]=>
  NULL
}
===DONE===
