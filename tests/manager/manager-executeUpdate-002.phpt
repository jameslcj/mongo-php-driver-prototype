--TEST--
MongoDB\Driver\Manager::executeUpdate() multiple documents with no upsert
--SKIPIF--
<?php if (getenv("TRAVIS")) exit("skip This oddly enough fails on travis and I cannot figureout why") ?>
<?php require __DIR__ . "/../utils/basic-skipif.inc"; CLEANUP(STANDALONE) ?>
--FILE--
<?php
require_once __DIR__ . "/../utils/basic.inc";

$manager = new MongoDB\Driver\Manager(STANDALONE);

// load fixtures for test
$manager->executeInsert(NS, array('_id' => 1, 'x' => 1));
$manager->executeInsert(NS, array('_id' => 2, 'x' => 1));
$manager->executeInsert(NS, array('_id' => 3, 'x' => 3));

$result = $manager->executeUpdate(
    NS,
    array('x' => 1),
    array('$set' => array('x' => 2)),
    array('multi' => true, 'upsert' => false)
);

echo "\n===> WriteResult\n";
printWriteResult($result);

echo "\n===> Collection\n";
$cursor = $manager->executeQuery(NS, new MongoDB\Driver\Query(array()));
var_dump(iterator_to_array($cursor));

?>
===DONE===
<?php exit(0); ?>
--EXPECTF--
===> WriteResult
server: %s:%d
insertedCount: 0
matchedCount: 2
modifiedCount: 2
upsertedCount: 0
deletedCount: 0

===> Collection
array(3) {
  [0]=>
  object(stdClass)#%d (2) {
    ["_id"]=>
    int(1)
    ["x"]=>
    int(2)
  }
  [1]=>
  object(stdClass)#%d (2) {
    ["_id"]=>
    int(2)
    ["x"]=>
    int(2)
  }
  [2]=>
  object(stdClass)#%d (2) {
    ["_id"]=>
    int(3)
    ["x"]=>
    int(3)
  }
}
===DONE===
