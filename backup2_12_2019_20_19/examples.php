<?php
session_start(); //sessions are like cookies, but the user cant touch them
if (!isset($_SESSION['e'])) {$_SESSION['e'] = 0;}

$_SESSION['e']++; //use sessions to store like, what user is logged in n stuff
echo $_SESSION['e']; //for normal variables, jsut fo $variablename
//no need to fuck with types, its like python yay
//but the syntax is more like C#

for ($i = 0; $i < 5; $i++) {
  echo "hi enaya this is number " . $i; //use . to combine things, + to like. add them.
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  echo $_POST['a'];
}

$json = json_decode(file_get_contents("file.json"), true);

echo $json['Hello'];

$json['uwu'] = "fhqwhgads";

require('uwu.php');

file_put_contents("file.json", json_encode($json));
//check the php docs they have like everything, and since php is so old you can easily google
// "how to do x in php"
?>