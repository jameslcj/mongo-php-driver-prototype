--TEST--
WriteConcernError: Access write counts and WriteConcern reason
--SKIPIF--
<?php require __DIR__ . "/../utils/basic-skipif.inc"; NEEDS("REPLICASET"); ?>
--FILE--
<?php
require_once __DIR__ . "/../utils/basic.inc";

$manager = new MongoDB\Driver\Manager(REPLICASET);

$bulk = new MongoDB\Driver\BulkWrite;

$bulk->insert(array("my" => "value"));
$bulk->insert(array("my" => "value", "foo" => "bar"));
$bulk->insert(array("my" => "value", "foo" => "bar"));

$bulk->delete(array("my" => "value", "foo" => "bar"), array("limit" => 1));

$bulk->update(array("foo" => "bar"), array('$set' => array("foo" => "baz")), array("limit" => 1, "upsert" => 0));

$w = new MongoDB\Driver\WriteConcern(30);
try {
    $retval = $manager->executeBulkWrite(NS, $bulk, $w);
} catch(MongoDB\Driver\Exception\BulkWriteException $e) {
    printWriteResult($e->getWriteResult(), false);
    $e->getWriteResult(true);
}
?>
===DONE===
<?php exit(0); ?>
--EXPECTF--
server: %s:%d
insertedCount: 3
matchedCount: 1
modifiedCount: 1
upsertedCount: 0
deletedCount: 1
writeConcernError: %s (%d)

Warning: MongoDB\Driver\Exception\WriteException::getWriteResult() expects exactly 0 parameters, 1 given in %s on line %d
===DONE===
