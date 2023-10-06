<?php
# This is a comment, and
# This is the second line of the comment
// This is a comment too. Each style comments only
print "An example with single line comments";

print "<br>";
print "<br>";
# First Example
print <<<END
This uses the "here document" syntax to output
multiple lines with variable interpolation. Note
that the here document terminator must appear on a
line with just a semicolon no extra whitespace!
END;
# Second Example
print "This spans
multiple lines. The newlines will be
output as well";

/* This is a comment with multiline
 Author : Mohammad Mohtashim
 Purpose: Multiline Comments Demo
 Subject: PHP
*/
print "<br>";
print "<br>";

print "An example with multi line comments";

print "<br>";
print "<br>";

 echo "Hello PHP!!!!!";

$many = 2.2888800;
$many_2 = 2.2111200;
$few = $many + $many_2;
print( $many + $many_2 = $few);


print "<br>";
print "<br>";
print "<br>";

$x = 4;
function assignx () {
$x = 0;
print "\$x inside function is $x.
";
}
assignx();
print "\$x outside of function is $x.
";

print "<br>";
print "<br>";

// multiply a value by 10 and return it to the caller
function multiply ($value) {
  $value = $value * 10;
  return $value;
 }
 $retval = multiply (10);
 Print "Return value is $retval\n";

print "<br>";
print "<br>";
 
 $somevar = 15;
function addit() {
GLOBAL $somevar;
$somevar++;
print "Somevar is $somevar";
}
addit();

print "<br>";
print "<br>";

function keep_track() {
  STATIC $count = 0;
  $count++;
  print $count;
  print "
 ";
}
keep_track();
keep_track();
keep_track();


?>