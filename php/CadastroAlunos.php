<?php
$CaminhoBanco = "C:/xampp/htdocs/Projeto cadastro e Listagem/sql/banco.txt";
$conexao = new PDO("sqlite:$CaminhoBanco");

// Configurar o PDO para gerar erros
$conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

// Verificar se as variáveis $_POST estão definidas
$NomeAluno = isset($_POST["NomeAluno"]) ? $_POST["NomeAluno"] : null;
$Telefone = isset($_POST["TelefoneAluno"]) ? $_POST["TelefoneAluno"] : null;
$Idade = isset($_POST["IdadeAluno"]) ? $_POST["IdadeAluno"] : null;
$HoraAula = isset($_POST["Hora"]) ? $_POST["Hora"] : null;
$ProfessorAula = isset($_POST["ProfessorAula"]) ? $_POST["ProfessorAula"] : null;
$ModalidadeAula = isset($_POST["ModalidadeAula"]) ? $_POST["ModalidadeAula"] : null;
echo "<pre>";
print_r($_POST);
echo "</pre>";
// Verificar se todas as variáveis estão definidas antes de continuar
if ($NomeAluno !== null && $Telefone !== null && $Idade !== null && $HoraAula !== null && $ProfessorAula !== null && $ModalidadeAula !== null ) {
    $sql = "INSERT INTO Alunos (NomeAlunos, TelefoneAluno, IdadeAluno, HoraAula, ProfessorAula, ModalidadeAula) VALUES (:NomeAluno, :Telefone, :Idade, :HoraAula, :ProfessorAula, :ModalidadeAula)";
   
    $stmt = $conexao->prepare($sql);

    $stmt->bindParam(':NomeAluno', $NomeAluno);
    $stmt->bindParam(':Telefone', $Telefone);
    $stmt->bindParam(':Idade', $Idade);
    $stmt->bindParam(':HoraAula', $HoraAula);
    $stmt->bindParam(':ProfessorAula', $ProfessorAula);
    $stmt->bindParam(':ModalidadeAula', $ModalidadeAula);

    // Tentar executar a consulta
    $resultado = $stmt->execute();

    // Verificar se ocorreram erros durante a execução
    if ($resultado === false) {
        echo "Erro ao registrar: " . implode(', ', $conexao->errorInfo());
    } else {
        echo "Registro bem-sucedido!";
        header("location:../php/ListagemAlunos.php");

    }
} else {
    echo "Algumas variáveis não foram fornecidas.";
}

// Fechar conexão
$conexao = null;
?>
