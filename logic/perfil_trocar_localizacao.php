<?php
session_start();
echo "Trocar localização do usuário " . $_SESSION['email'];

//quando terminar a troca, redirecionar para
//header('Location: ../public/Perfil/meu_perfil.php?status=localiza%C3%A7%C3%A3o%20alterada%20com%20sucesso');