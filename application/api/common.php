<?php
use \Firebase\JWT\JWT;

function setToken($value){
    $key = "example_key";
    $token = array(
        'account' => $value ->user_account,
        'psw' => $value ->user_psw,
    );
    $jwt = JWT::encode($token, $key);
    $decoded = JWT::decode($jwt, $key, array('HS256'));
    return $jwt;
}