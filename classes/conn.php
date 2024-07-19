
<?php
    $host = "localhost"; /* nome da conexão */
    $usuario = "root"; /* nome do usuario da conexãp */
    $senha = ""; /*senha do banco de dados caso exista */
    $nome = "ativihouse_1_0"; /* nome do seu banco  */
    $conn = new mysqli($host, $usuario, $senha, $nome);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $_SESSION['dominio'] = 'http://localhost/ativihouse_1_0/';

    date_default_timezone_set('America/Sao_Paulo');
?>