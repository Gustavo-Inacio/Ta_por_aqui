<?php
session_start();
if ((isset($_SESSION['idUsuario']) && $_SESSION['idUsuario'] != '') && (isset($_SESSION['email']) && $_SESSION['email'] != '') && (isset($_SESSION['senha']) && $_SESSION['senha'] != '')){
    echo 'true';
} else{
    echo 'false';
}