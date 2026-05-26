<?php

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

include("conexao.php");

if(!isset($_SESSION['usuario'])){
 header("Location:index.php");
}


if(isset($_POST['salvar'])){

$nome = $_POST['nome'];
$fabricante = $_POST['fabricante'];
$preço = $_POST['preço'];
$validade = $_POST['validade'];
$peso_embalagem = $_POST['peso_embalagem'];
$indicacao = $_POST['indicacao'];
$faixa_etaria = $_POST['faixa_etaria'];
$sabor = $_POST['sabor'];
$categoria = $_POST['categoria'];
$estoque = $_POST['estoque'];
$minimo = $_POST['minimo'];

if($nome == "" || $fabricante == "" || $preço == "" || $validade == "" || $peso_embalagem == "" || $indicacao == "" || $validade == "" || $fabricante == "" || $preço == "" || $validade == ""){
 echo "Preencha todos os campos <br><br>";
}else{

mysqli_query($conn,"INSERT INTO produtos
(nome,marca,estoque,minimo)
VALUES
('$nome','$marca','$estoque','$minimo')");
}
}


if(isset($_GET['excluir'])){

$id = $_GET['excluir'];

// primeiro apaga dependências
mysqli_query($conn,"
DELETE FROM movimentacoes
WHERE produtos_idprodutos='$id'
");

// depois apaga o produto
mysqli_query($conn,"
DELETE FROM produtos
WHERE idprodutos='$id'
");

}

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Gestão de Estoque</title>
<link rel="stylesheet" href="style.css">
</head>

<h2>Cadastro de Produtos</h2>

<form method="post">

Nome:<br>
<input type="text" name="nome"><br>

Marca:<br>
<input type="text" name="marca"><br>

Estoque:<br>
<input type="number" name="estoque"><br>

Minimo:<br>
<input type="number" name="minimo"><br><br>

<input type="submit" name="salvar" value="Salvar">

</form>

<hr>

<form method="get">

Buscar Produto:<br>
<input type="text" name="busca">
<input type="submit" value="Buscar">

</form>

<hr>

<table border="1" cellpadding="5">

<tr>
<th>ID</th>
<th>Nome</th>
<th>Marca</th>
<th>Estoque</th>
<th>Minimo</th>
<th>Ações</th>
</tr>

<?php

$busca = "";

if(isset($_GET['busca'])){
$busca = $_GET['busca'];
}

$sql = "SELECT * FROM produtos
WHERE nome LIKE '%$busca%'";

$resultado = mysqli_query($conn,$sql);

while($dados = mysqli_fetch_assoc($resultado)){

echo "<tr>";

echo "<td>".$dados['idprodutos']."</td>";
echo "<td>".$dados['nome']."</td>";
echo "<td>".$dados['marca']."</td>";
echo "<td>".$dados['estoque']."</td>";
echo "<td>".$dados['minimo']."</td>";

echo "<td>
<a href='produtos.php?excluir=".$dados['idprodutos']."'>Excluir</a>
</td>";

echo "</tr>";
}
?>

</table>

<br>

<a href="painel.php">Voltar ao Painel</a>