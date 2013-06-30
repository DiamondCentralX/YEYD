<?php
// YEYD - DB Connect
// Last updated: 30.06.2013

$db = new PDO('mysql:host=' . $DB['host'] . ';port=' . $DB['port'] . ';dbname=' . $DB['name'], $DB['user'], $DB['pass']);
?>
