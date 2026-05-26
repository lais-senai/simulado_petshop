<?php
include("conexao.php");

if(!isset($_SESSION['usuario'])){
 header("Location:index.php");
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>painel</title>
<link rel="stylesheet" href="style.css">
</head>

<body>

<h2>Bem-vindo <?php echo $_SESSION['usuario']; ?></h2>

<form style="text-align:center; background:none; box-shadow:none;">

<a href="produtos.php">
<button type="button">Cadastro de Produtos</button>
</a>

<br><br>

<a href="estoque.php">
<button type="button">Gestão de Estoque</button>
</a>

<br><br>

<a href="logout.php">
<button type="button">Logout</button>
</a>

</form>

</body>
</html>