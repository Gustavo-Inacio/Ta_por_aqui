<?php
session_start();

//destruindo session
session_destroy();

//destruindo cookies
setcookie('idUsuario', null, -1, '/'); //expira em 30 dias
setcookie('email', null, -1, '/');
setcookie('senha', null, -1, '/');
setcookie('classificacao', null, -1, '/');

//redirecionando
header('Location: ../public/Entrar/login.php');