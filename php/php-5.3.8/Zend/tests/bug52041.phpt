--TEST--
Bug #52041 (Memory leak when writing on uninitialized variable returned from function)
--FILE--
<?php
function foo() {
	return $x;
}

foo()->a = 1;
foo()->a->b = 2;
foo()->a++;
foo()->a->b++;
foo()->a += 2;
foo()->a->b += 2;

//foo()[0] = 1;
//foo()[0][0] = 2;
//foo()[0]++;
//foo()[0][0]++;
//foo()[0] += 2;
//foo()[0][0] += 2;
var_dump(foo());
?>
--EXPECTF--
Notice: Undefined variable: x in %sbug52041.php on line 3

Strict Standards: Creating default object from empty value in %sbug52041.php on line 6

Notice: Undefined variable: x in %sbug52041.php on line 3

Strict Standards: Creating default object from empty value in %sbug52041.php on line 7

Notice: Undefined variable: x in %sbug52041.php on line 3

Strict Standards: Creating default object from empty value in %sbug52041.php on line 8

Notice: Undefined variable: x in %sbug52041.php on line 3

Strict Standards: Creating default object from empty value in %sbug52041.php on line 9

Notice: Undefined variable: x in %sbug52041.php on line 3

Strict Standards: Creating default object from empty value in %sbug52041.php on line 10

Notice: Undefined variable: x in %sbug52041.php on line 3

Strict Standards: Creating default object from empty value in %sbug52041.php on line 11

Notice: Undefined variable: x in %sbug52041.php on line 3
NULL
