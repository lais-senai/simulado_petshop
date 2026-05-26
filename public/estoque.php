<?php
include("conexao.php");

if(!isset($_SESSION['usuario'])){
 header("Location:index.php");
}


if(isset($_POST['movimentar'])){

$id = $_POST['produto'];
$tipo = $_POST['tipo'];
$qtd = $_POST['quantidade'];
$data = $_POST['data'];

$busca = mysqli_query($conn,
"SELECT * FROM produtos WHERE idprodutos='$id'");

$produto = mysqli_fetch_assoc($busca);

$estoque = $produto['estoque'];
$minimo = $produto['minimo'];

if($tipo == "entrada"){
 $novo = $estoque + $qtd;
}else{
 $novo = $estoque - $qtd;
}

mysqli_query($conn,
"UPDATE produtos SET estoque='$novo'
WHERE idprodutos='$id'");

mysqli_query($conn,
"INSERT INTO movimentacoes
(tipo,quant,data_mov,usuario,produtos_idprodutos)
VALUES
('$tipo','$qtd','$data','".$_SESSION['usuario']."','$id')");

if($novo < $minimo){
 echo "ALERTA: Estoque abaixo do mínimo!<br><br>";
}

echo "Movimentação realizada.<br><br>";
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Gestão de Estoque</title>
<link rel="stylesheet" href="style.css">
</head>

<h2>Gestão de Estoque</h2>

<form method="post">

Produto:<br>

<select name="produto">

<?php

$sql = mysqli_query($conn,
"SELECT * FROM produtos ORDER BY nome ASC");

while($d = mysqli_fetch_assoc($sql)){

echo "<option value='".$d['idprodutos']."'>".$d['nome']."</option>";

}
?>

</select><br><br>

Tipo:<br>

<select name="tipo">
<option value="entrada">Entrada</option>
<option value="saida">Saída</option>
</select><br><br>

Quantidade:<br>
<input type="number" name="quantidade"><br><br>

Data:<br>
<input type="date" name="data"><br><br>

<input type="submit" name="movimentar" value="Salvar">

</form>

<hr>

<h3>Produtos em Estoque</h3>

<table border="1" cellpadding="5">

<tr>
<th>Produto</th>
<th>Estoque</th>
<th>Mínimo</th>
</tr>

<?php

$listar = mysqli_query($conn,
"SELECT * FROM produtos ORDER BY nome ASC");

while($x = mysqli_fetch_assoc($listar)){

echo "<tr>";
echo "<td>".$x['nome']."</td>";
echo "<td>".$x['estoque']."</td>";
echo "<td>".$x['minimo']."</td>";
echo "</tr>";
}
?>

</table>

<br>

<a href='painel.php'>Voltar ao Painel</a>





