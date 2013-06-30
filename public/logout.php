<?php
require 'core/init.php';

unset($_SESSION['user_id']);
header('Location: home' . $site_fileext);
?>