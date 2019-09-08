<?php


class User
{
    private $logged = false;
    public $email;
    public $name;
    public $status;

    public function __construct($session_data = null)
    {
        if (is_array($session_data) && isset($session_data['email'])) {
            $this->logged = true;
            $this->email = $session_data['email'];
            $this->name = $session_data['name'];
            $this->status = $session_data['status'];
        } elseif (isset($_COOKIE['email'])) {
            $this->logged = true;
            $this->email = $_COOKIE['email'];
            $this->name = $_COOKIE['name'];
            $this->status = $_COOKIE['status'];
        }
    }

    public function isLogged()
    {
        return $this->logged;
    }
}