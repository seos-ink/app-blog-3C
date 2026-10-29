<?php

require_once "../../_conn/connect.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: listar.php");
    exit;
}


/*
|--------------------------------------------------------------------------
| Receber dados
|--------------------------------------------------------------------------
*/

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$telefone = trim($_POST['telefone'] ?? '');
$slug = trim($_POST['slug'] ?? '');
$status = $_POST['status'] ?? '';
$level = filter_input(INPUT_POST, 'level', FILTER_VALIDATE_INT);

$pass = $_POST['pass'] ?? '';
$pass_confirm = $_POST['pass_confirm'] ?? '';


/*
|--------------------------------------------------------------------------
| Validação
|--------------------------------------------------------------------------
*/

if (!$id) {
    header("Location: index.php?erro=id");
    exit;
}

if (empty($name) || empty($email) || empty($slug)) {
    header("Location: form.php?id=$id&erro=campos");
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: form.php?id=$id&erro=email");
    exit;
}

if ($level === false || $level === null) {
    header("Location: form.php?id=$id&erro=level");
    exit;
}


/*
|--------------------------------------------------------------------------
| Verificar senha
|--------------------------------------------------------------------------
*/

if (!empty($pass)) {

    if ($pass !== $pass_confirm) {
        header("Location: form.php?id=$id&erro=senha");
        exit;
    }

    $senhaHash = password_hash($pass, PASSWORD_DEFAULT);
}


/*
|--------------------------------------------------------------------------
| Buscar usuário atual
|--------------------------------------------------------------------------
*/

$sql = "SELECT image 
        FROM users 
        WHERE id = :id
        LIMIT 1";

$stmt = $con->prepare($sql);

$stmt->bindValue(':id', $id, PDO::PARAM_INT);

$stmt->execute();

$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    header("Location: index.php?erro=usuario");
    exit;
}