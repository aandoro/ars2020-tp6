<?php

include('call_api.php');

class Login
{
    var $username;
    var $password;


    function login($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
        $make_call = callAPI('POST', 'http://localhost:3000/login', json_encode($this));
        $response = json_decode($make_call, true);
        return $response;
    }
}
