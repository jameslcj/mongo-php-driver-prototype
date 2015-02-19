--TEST--
WriteConcernError: Populate WriteConcernError on WriteConcern errors
--SKIPIF--
<?php require "tests/utils/basic-skipif.inc"?>
--FILE--
<?php
require_once "tests/utils/basic.inc";

$mc = new MongoDB\Driver\Manager(MONGODB_REPLICASET_URI);

$batch = new MongoDB\Driver\WriteBatch;

$batch->insert(array("my" => "value"));

$w = new MongoDB\Driver\WriteConcern(30, 100);
$retval = $mc->executeWriteBatch(NS, $batch, $w);

printWriteResult($retval);
?>
===DONE===
<?php exit(0); ?>
--EXPECTF--
server: %s:%d
insertedCount: 1
matchedCount: 0
modifiedCount: 0
upsertedCount: 0
deletedCount: 0
object(MongoDB\Driver\WriteConcernError)#%d (%d) {
  ["message"]=>
  string(33) "waiting for replication timed out"
  ["code"]=>
  int(64)
  ["info"]=>
  array(1) {
    ["wtimeout"]=>
    bool(true)
  }
}
writeConcernError.message: waiting for replication timed out
writeConcernError.code: 64
writeConcernError.info: array(1) {
  ["wtimeout"]=>
  bool(true)
}
===DONE===
