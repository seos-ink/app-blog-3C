<?php
require_once '../../conn/conect.php';
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($id) {
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = :id");
    $stmt->bindParam(':id', $id);
    if ($stmt->execute()) {
        header("Location: index.php?deleted=true");
    } else {
        header("Location: index.php?error=true");
    }
} else {
    header("Location: index.php");
}
exit;