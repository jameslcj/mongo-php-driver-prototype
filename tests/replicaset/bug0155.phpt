--TEST--
MongoDB\Driver\WriteConcern construction
--SKIPIF--
<?php require __DIR__ . "/../utils/basic-skipif.inc"; NEEDS("REPLICASET"); ?>
--FILE--
<?php
require_once __DIR__ . "/../utils/basic.inc";

$manager = new MongoDB\Driver\Manager(REPLICASET);


$wc = new MongoDB\Driver\WriteConcern("MultipleDC", 500);

$doc = array("example" => "document");
try {
    $result = $manager->executeInsert("databaseName.collectionName", $doc, $wc);
} catch(MongoDB\Driver\Exception\WriteConcernException $e) {
    var_dump($e->getWriteResult()->getWriteConcernError());
}
?>
===DONE===
<?php exit(0); ?>
--EXPECTF--
object(MongoDB\Driver\WriteConcernError)#%d (%d) {
  ["message"]=>
  string(%d) "%s"
  ["code"]=>
  int(79)
  ["info"]=>
  NULL
}
===DONE===
