<?php
setcookie('allowChangePass', 1, time() + 10, '/'); //expira em 20 segundos
header("location: ../public/TrocarSenha/trocarSenha.php");