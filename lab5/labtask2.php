<?php

$password = $_POST["password"];
$newpassword = $_POST["newpassword"];
$repassword = $_POST["repassword"];

if ($password == $newpassword) {
    echo("Password cannot be the same as the previous one.");
} elseif ($newpassword != $repassword) {
    echo("New password and re-entered password do not match.");
} elseif ($password != $newpassword && $newpassword == $repassword) {
    echo("Password changed successfully.");
} else {
    echo("Invalid password change request.");
}
?>
