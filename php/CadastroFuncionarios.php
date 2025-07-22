<?php
$CaminhoBanco = "C:/xampp/htdocs/Projeto-cadastro-e-Listagem/sql/banco.txt";
$conexao = new PDO("sqlite:$CaminhoBanco");

// Configurar o PDO para gerar erros
$conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

// Verificar se as variáveis $_POST estão definidas
$NomeFuncionario = isset($_POST["NomeFuncionario"]) ? $_POST["NomeFuncionario"] : null;
$TelefoneFuncionario = isset($_POST["TelefoneFuncionario"]) ? $_POST["TelefoneFuncionario"] : null;
$IdadeFuncionario = isset($_POST["IdadeFuncionario"]) ? $_POST["IdadeFuncionario"] : null;
$ModalidadeProfessor = isset($_POST["ModalidadeProfessor"]) ? $_POST["ModalidadeProfessor"] : null;

// Verificar se todas as variáveis estão definidas antes de continuar
if ($NomeFuncionario !== null && $TelefoneFuncionario !== null && $IdadeFuncionario !== null && $ModalidadeProfessor !== null  ) {
    $sql = "INSERT INTO Funcionarios (NomeFuncionario, TelefoneFunciionario, IdadeFuncionario, Modalidade) VALUES (:NomeFuncionario, :TelefoneFuncionario, :IdadeFuncionario, :ModalidadeProfessor)";
   
    $stmt = $conexao->prepare($sql);

    $stmt->bindParam(':NomeFuncionario', $NomeFuncionario);
    $stmt->bindParam(':TelefoneFuncionario', $TelefoneFuncionario);
    $stmt->bindParam(':IdadeFuncionario', $IdadeFuncionario);
    $stmt->bindParam(':ModalidadeProfessor', $ModalidadeProfessor);
    

    // Tentar executar a consulta
    $resultado = $stmt->execute();

    // Verificar se ocorreram erros durante a execução
    if ($resultado === false) {
        echo "Erro ao registrar: " . implode(', ', $conexao->errorInfo());
    } else {
        echo "Registro bem-sucedido!";
        header("location:../php/ListagemFuncionarios.php");
        
    }
} else {
    echo "Algumas variáveis não foram fornecidas.";
}

// Fechar conexão
$conexao = null;
?>
