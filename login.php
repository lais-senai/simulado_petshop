<?php
include("conexao.php");

$login = $_POST['email'];
$senha = $_POST['senha'];

$sql = "SELECT * FROM usuarios 
WHERE email='$email' AND senha='$senha'";

$resultado = mysqli_query($conn,$sql);

if(mysqli_num_rows($resultado) > 0){

 $dados = mysqli_fetch_assoc($resultado);

 $_SESSION['usuario'] = $dados['nome'];

 header("Location:painel.php");

}else{

 echo "Email ou senha inválidos";

 header("refresh:2;url=index.php");

}
?>