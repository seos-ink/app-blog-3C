<?php
require_once '../../conn/conect.php';

$post = filter_input_array(INPUT_POST, FILTER_DEFAULT);

// validação do form.php
if (empty($post['title']) || empty($post['description']) || empty($post['id_status']) || empty($post['image'])) {
	header('Location: form.php?errornull=true');
	exit();
}

// // ternária, se existir o campo status, atribui 1. Caso contrário, atribui 0.
// $post['status'] = isset($post['status']) ? 1 : 0;

// remover o array de confirmação de senha
// unset($post['pass_confirm']);

// criptografia da senha usando md5
// $post['password'] = md5($post['password']);

// modo -- Inserção dinâmica
$table = 'products';
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

/*
$dir = "../../uploads/images/users";
if (!is_dir($dir)) {
	mkdir($dir, 0755, true);
}

if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
	$ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
	$basename = pathinfo($_FILES['image']['name'], PATHINFO_FILENAME);
	$newname = $basename . '_'  . $ext;
	$counter = 1;

	while (file_exists($dir . '/' . $newname)) {
		$newname = $basename . '_' . $counter . '.' . $ext;
		$counter++;
	}
	
	if(move_uploaded_file($_FILES['image']['tmp_name'], $dir . '/' . $newname)) {
		$post['image'] = $newname;		
	}
} else { 
	unset($post['image']);
}
*/