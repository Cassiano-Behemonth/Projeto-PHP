<?php


session_start();


define('SITE_NOME', 'Cadastro de jogos favorito');
define('SITE_DESC', 'Feito por Cassiano(Behemonth)');

$usuarios_registrados = [];
$usuarios_registrados['teste'] = password_hash('123', PASSWORD_DEFAULT);
$usuarios_registrados['admin'] = password_hash('admin123', PASSWORD_DEFAULT);
$usuarios_registrados['novo_usuario'] = password_hash('senhafacil', PASSWORD_DEFAULT);
$usuarios_registrados['outro_teste'] = password_hash('outrasenha', PASSWORD_DEFAULT);
