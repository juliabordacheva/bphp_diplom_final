<?php
require 'config/autoloader.php';

session_start();

if (isset($_POST['email']) && isset($_POST['password'])) {
    $jsonFileAccessModel = new JsonFileAccessModel('allUsers');
    $users = json_decode($jsonFileAccessModel->read(), true);
    foreach ($users as $user) {
        if ($user['email'] == $_POST['email'] && $user['password'] == $_POST['password']) {
            $_SESSION['email'] = $user['email'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['status'] = $user['status'];
            setcookie('email', $user['email'], time() + Config::COOKIE_LIFE_TIME);
            setcookie('name', $user['name'], time() + Config::COOKIE_LIFE_TIME);
            setcookie('status', $user['status'], time() + Config::COOKIE_LIFE_TIME);
        }
    }
}

header('Location: index.php');