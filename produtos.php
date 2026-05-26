<?php

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

include("conexao.php");

if (!isset($_SESSION['usuario'])) {
    header("Location:index.php");
    exit;
}

if (isset($_POST['salvar'])) {

    $nome = $_POST['nome'];
    $fabricante = $_POST['fabricante'];
    $preco = $_POST['preco'];
    $validade = $_POST['validade'];
    $peso_embalagem = $_POST['peso_embalagem'];
    $indicacao = $_POST['indicacao'];
    $faixa_etaria = $_POST['faixa_etaria'];
    $sabor = $_POST['sabor'];
    $categoria = $_POST['categoria'];
    $estoque = $_POST['estoque'];
    $minimo = $_POST['minimo'];

    if (
        $nome == "" || $fabricante == "" || $preco == "" || $validade == "" ||
        $peso_embalagem == "" || $indicacao == "" || $faixa_etaria == "" ||
        $sabor == "" || $categoria == "" || $estoque == "" || $minimo == ""
    ) {
        echo "Preencha todos os campos <br><br>";
    } else {

        $sql = "INSERT INTO produtos
        (nome, fabricante, preco, validade, peso_embalagem, indicacao, faixa_etaria, sabor, categoria, estoque, minimo)
        VALUES
        ('$nome', '$fabricante', '$preco', '$validade', '$peso_embalagem', '$indicacao', '$faixa_etaria', '$sabor', '$categoria', '$estoque', '$minimo')";

        mysqli_query($conn, $sql);

        echo "Produto cadastrado com sucesso! <br><br>";
    }
}

if (isset($_GET['excluir'])) {

    $id = $_GET['excluir'];

    mysqli_query($conn, "
        DELETE FROM movimentacoes
        WHERE produtos_idprodutos='$id'
    ");

    mysqli_query($conn, "
        DELETE FROM produtos
        WHERE idprodutos='$id'
    ");

    echo "Produto excluído com sucesso! <br><br>";
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Gestão de Estoque</title>
</head>
<body>

<h2>Cadastro de Produtos</h2>

<form method="post">

    Nome:<br>
    <input type="text" name="nome"><br><br>

    Fabricante:<br>
    <input type="text" name="fabricante"><br><br>

    Preço:<br>
    <input type="number" step="0.01" name="preco"><br><br>

    Validade:<br>
    <input type="date" name="validade"><br><br>

    Peso da Embalagem:<br>
    <input type="text" name="peso_embalagem"><br><br>

    Indicação:<br>
    <input type="text" name="indicacao"><br><br>

    Faixa Etária:<br>
    <input type="text" name="faixa_etaria"><br><br>

    Sabor:<br>
    <input type="text" name="sabor"><br><br>

    Categoria:<br>
    <input type="text" name="categoria"><br><br>

    Estoque:<br>
    <input type="number" name="estoque"><br><br>

    Mínimo:<br>
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
    <th>Fabricante</th>
    <th>Preço</th>
    <th>Validade</th>
    <th>Peso</th>
    <th>Indicação</th>
    <th>Faixa Etária</th>
    <th>Sabor</th>
    <th>Categoria</th>
    <th>Estoque</th>
    <th>Mínimo</th>
    <th>Ações</th>
</tr>

<?php

$busca = "";

if (isset($_GET['busca'])) {
    $busca = $_GET['busca'];
}

$sql = "SELECT * FROM produtos
        WHERE nome LIKE '%$busca%'";

$resultado = mysqli_query($conn, $sql);

while ($dados = mysqli_fetch_assoc($resultado)) {

    echo "<tr>";

    echo "<td>".$dados['idprodutos']."</td>";
    echo "<td>".$dados['nome']."</td>";
    echo "<td>".$dados['fabricante']."</td>";
    echo "<td>".$dados['preco']."</td>";
    echo "<td>".$dados['validade']."</td>";
    echo "<td>".$dados['peso_embalagem']."</td>";
    echo "<td>".$dados['indicacao']."</td>";
    echo "<td>".$dados['faixa_etaria']."</td>";
    echo "<td>".$dados['sabor']."</td>";
    echo "<td>".$dados['categoria']."</td>";
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

</body>
</html>