<?php
setcookie('allowChangePass', 1, time() + 3600000, '/'); //expira em 1 hora
header("location: ../public/EsqueceuSenha/esqueceuSenha.php");