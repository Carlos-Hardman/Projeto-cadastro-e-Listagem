<?php
$CaminhoBanco = "C:/xampp/htdocs/Projeto cadastro e Listagem/sql/banco.txt";
$conexao = new PDO("sqlite:$CaminhoBanco");

// Configurar o PDO para gerar erros
$conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

// Número de registros por página
$porPagina = 11;

// Verificar qual página estamos
$paginaAtual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
$inicio = ($paginaAtual - 1) * $porPagina;

// Contar o número total de alunos
$sqlTotal = "SELECT COUNT(*) as total FROM Alunos";
$stmtTotal = $conexao->query($sqlTotal);
$resultadoTotal = $stmtTotal->fetch(PDO::FETCH_ASSOC);
$totalAlunos = $resultadoTotal['total'];

// Calcular número total de páginas
$totalPaginas = ceil($totalAlunos / $porPagina);

// Consulta para selecionar alunos com paginação
$sql = "SELECT * FROM Funcionarios LIMIT :limite OFFSET :offset";
$stmt = $conexao->prepare($sql);

// Vincular parâmetros para garantir segurança contra SQL Injection
$stmt->bindParam(':limite', $porPagina, PDO::PARAM_INT);
$stmt->bindParam(':offset', $inicio, PDO::PARAM_INT);

// Executar a consulta
$stmt->execute();
$alunos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fechar conexão
$conexao = null;
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/main.css">
    <title>Operamax</title>
    <style>
        table {
            width: 80%; /* Ajusta a largura da tabela */
            margin: 20px auto;
            border-collapse: collapse;
            max-width: 900px; /* Limita a largura máxima da tabela */
        }
        th, td {
            padding: 8px 12px; /* Diminui o padding para tornar a tabela mais compacta */
            text-align: left;
            border: 1px solid #ddd;
            font-size: 14px; /* Tamanho de fonte reduzido */
        }
        th {
            background-color: #f4f4f4;
        }
        .paginacao {
            margin-top: 20px;
            text-align: center;
        }
        .paginacao a,
        .paginacao span {
            margin: 0 5px;
            padding: 8px 12px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .paginacao a:hover {
            background-color: #0056b3;
        }
        .paginacao span {
            background-color: #ccc;
            color: #333;
        }

        /* Certifique-se de que a paginação aparece na horizontal */
        .paginacao {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
        }

        .paginacao a,
        .paginacao span {
            margin-right: 5px;
        }
    </style>
</head>

<body>
    <main>
        <div class="conteinerOperacao">
            <h1 id="Logo">Operamax</h1>

            <div class="DivListagem">
                <a href="../php/ListagemFuncionarios.php" class="ListagemFuncionarios">Listagem de Funcionarios</a>
                <a href="../php/ListagemAlunos.php" class="ListagemAlunos">Listagem de Alunos</a>
            </div>
            <div class="DivCadastro">
                <a href="../html/CadastroFuncionario.html" class="CadastroFuncionarios">Cadastrar Funcionarios</a>
                <a href="../html/CadastroAlunos.html" class="CadastroAlunos">Cadastrar Alunos</a>
            </div>
        </div>
        
        <!-- Listagem de Alunos -->
        <div class="infoPadrao">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Telefone</th>
                        <th>Idade</th>
                        <th>Modalidade</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Exibir os alunos na tabela
                    foreach ($alunos as $aluno) {
                        echo "<tr>
                            <td>{$aluno['ID']}</td>  <!-- Verifique se 'ID' é o nome correto da coluna -->
                            <td>{$aluno['NomeFuncionario']}</td>
                            <td>{$aluno['TelefoneFunciionario']}</td>
                            <td>{$aluno['IdadeFuncionario']}</td>
                            <td>{$aluno['Modalidade']}</td>
                        </tr>";
                    }
                    ?>
                </tbody>
            </table>

            <!-- Paginação -->
            <div class="paginacao">
                <?php
                // Se a página atual for maior que 1, exibe o link "Anterior"
                if ($paginaAtual > 1) {
                    echo "<a href='?pagina=" . ($paginaAtual - 1) . "'>&laquo; Anterior</a>";
                }

                // Loop para exibir os números de página
                for ($i = 1; $i <= $totalPaginas; $i++) {
                    if ($i == $paginaAtual) {
                        echo "<span>$i</span>";
                    } else {
                        echo "<a href='?pagina=$i'>$i</a>";
                    }
                }

                // Se a página atual for menor que o número total de páginas, exibe o link "Próxima"
                if ($paginaAtual < $totalPaginas) {
                    echo "<a href='?pagina=" . ($paginaAtual + 1) . "'>Próxima &raquo;</a>";
                }
                ?>
            </div>
        </div>
    </main>
    
    <div class="bordatop"></div>
    <div class="bordabottom"></div>
</body>

</html>
