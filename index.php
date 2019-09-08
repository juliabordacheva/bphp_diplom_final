<?php
require 'config/autoloader.php';
session_start();
$user = new User($_SESSION);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Бюро переводов</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/main.css">
    <link href="https://fonts.googleapis.com/css?family=Dancing+Script|Maven+Pro&display=swap" rel="stylesheet">
<body>
<?php
if ($user->isLogged()) {
    include 'adminka.php';
} else {
   include 'login.php';
}
?>

</body>
</html>
