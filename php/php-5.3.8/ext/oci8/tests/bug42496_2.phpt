--TEST--
Bug #42496 (LOB fetch leaks cursors, eventually failing with ORA-1000 maximum open cursors reached)
--SKIPIF--
<?php
$target_dbs = array('oracledb' => true, 'timesten' => false);  // test runs on these DBs
require(dirname(__FILE__).'/skipif.inc');
if ($stress_test !== true) die ('skip Slow test not run when $stress_test is FALSE');
?> 
--FILE--
<?php

require dirname(__FILE__).'/connect.inc';

// Initialization

$stmtarray = array(
	"DROP table bug42496_tab",
	"CREATE table bug42496_tab(c1 CLOB, c2 CLOB)",
	"INSERT INTO bug42496_tab VALUES('test1', 'test1')",
	"INSERT INTO bug42496_tab VALUES('test2', 'test2')",
	"INSERT INTO bug42496_tab VALUES('test3', 'test3')"
);

oci8_test_sql_execute($c, $stmtarray);

// Run Test

echo "Test 2\n";

for ($i = 0; $i < 15000; $i++) {
	$s = oci_parse($c, "SELECT * from bug42496_tab");
	if (oci_execute($s)) {
		$arr = array();
		while ($arr = oci_fetch_assoc($s)) {
			$arr['C1']->free();
			$arr['C2']->free();
		}
	}
	oci_free_statement($s);
}

echo "Done\n";

// Cleanup

$stmtarray = array(
	"DROP table bug42496_tab"
);

oci8_test_sql_execute($c, $stmtarray);

?>
--EXPECTF--
Test 2
Done
