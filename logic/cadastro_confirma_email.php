<?php
$code = rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9);
$confirmEmail = ['email' => $_GET['email'], 'code' => $code];

json_encode($confirmEmail);
