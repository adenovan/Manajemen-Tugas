<?php 
session_start();
session_destroy();
$notice ="logout berhasil";
	header('Location: http://manajemen-tugas.dev/index?notice='.$notice);
?>
