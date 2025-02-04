--TEST--
MongoDB\Driver\Manager::executeUpdate() multiple documents with upsert
--SKIPIF--
<?php require __DIR__ . "/../utils/basic-skipif.inc"; CLEANUP(STANDALONE) ?>
--FILE--
<?php
require_once __DIR__ . "/../utils/basic.inc";

$manager = new MongoDB\Driver\Manager(STANDALONE);

$result = $manager->executeUpdate(
    NS,
    array('_id' => 1),
    array('$set' => array('x' => 1)),
    array('multi' => true, 'upsert' => true)
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
matchedCount: 0
modifiedCount: 0
upsertedCount: 1
deletedCount: 0
upsertedId[0]: int(1)

===> Collection
array(1) {
  [0]=>
  object(stdClass)#%d (2) {
    ["_id"]=>
    int(1)
    ["x"]=>
    int(1)
  }
}
===DONE===
