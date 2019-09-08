<?php
session_start();
setcookie('email', $_SESSION['email'], time() - 100);
setcookie('name', $_SESSION['name'], time() - 100);
setcookie('status', $_SESSION['status'], time() - 100);
session_destroy();

header('Location: index.php');
