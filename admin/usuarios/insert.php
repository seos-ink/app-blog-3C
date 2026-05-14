<?php
require_once '../../conn/conect.php';

$post = filter_input_array(INPUT_POST, FILTER_DEFAULT);

// validação do form.php
if (empty($post['name']) || empty($post['email']) || empty($post['phone']) || empty($post['password']) || empty($post['pass_confirm'])) {
	header('Location: form.php?errornull=true');
	exit();
}
if ($post['password'] !== $post['pass_confirm']) {
	header('Location: form.php?errorhash=true');
	exit();
}

// Verificação se já existe o e-mail cadastrado no banco de dados
$stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
$stmt->bindParam(':email', $post['email']);
$stmt->execute();
$emailCount = $stmt->fetchColumn();
if ($emailCount > 0) {
    header('Location: form.php?erroremail=True'); 
    exit;
}

// ternária, se existir o campo status, atribui 1. Caso contrário, atribui 0.
$post['status'] = isset($post['status']) ? 1 : 0;

// remover o array de confirmação de senha
unset($post['pass_confirm']);

// criptografia da senha usando md5
$post['password'] = md5($post['password']);

// modo -- Inserção dinâmica
$table = 'users';
$fields = [];
$placeholders = [];
foreach ($post as $key => $value) {
	$fields[] = $key;
	$placeholders[] = ':' . $key;
}
$sql = "INSERT INTO $table (" . implode(', ', $fields) . ") VALUES (" . implode(', ', $placeholders) . ")";
$stmt = $pdo->prepare($sql);
foreach ($post as $key => $value) {
	$stmt->bindValue(':' . $key, $value);
}
if($stmt->execute()) {
	header('Location: form.php?success=true');
} else {
	header('Location: form.php?error=true');
}