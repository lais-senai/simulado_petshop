<?php
$conn = mysqli_connect("localhost","root","","petshop_db");

if(!$conn){
    die("Erro na conexao");
}

session_start();

?>

