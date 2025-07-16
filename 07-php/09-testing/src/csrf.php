<?php 

function setCSRF(): void
{
    if(session_status() !== PHP_SESSION_ACTIVE)
    {
        session_start();
    }
    $token = bin2hex(random_bytes(16));
    $_SESSION["csrf_token"] = $token;
    echo "<input type='hidden' name='csrf_token' value='$token'>";
}