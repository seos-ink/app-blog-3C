### CRUD EM PROJETO A PARTE (Apenas o CRUD)

1. BANCO:

```
CREATE DATABASE IF NOT EXISTS crud3c;

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL
)
```

----
### PROJETO NO VISUAL STUDIO CODE

2. connect.php

```
<?php

$host = 'localhost';
$user = 'root';
$password = '';
$database = 'crud3c';

try {
    $conn = new PDO("mysql:host=$host;dbname=$database", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
```

----------------------- 

3. index.php

```
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h2>CRUD</h2>
    <ul>
        <li><a href="form.php">Formulário</a></li>
        <li><a href="select.php">Listagem</a></li>
    </ul>
</body>
</html>
```

----------------------- 

4. form.php

```
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<form action="insert.php" method="post">
    <label for="title">Título:</label>
    <input type="text" name="title"><br><br>

    <label for="description">Descrição:</label>
    <textarea name="description"></textarea><br><br>

    <input type="submit" value="Submit">

</form>

<a href="index.php">Voltar</a>
    
</body>
</html>
```

----------------------- 

5. insert.php

```
<?php
include 'connect.php';
$post = filter_input_array(INPUT_POST);
// var_dump($post);
$sql = "INSERT INTO products (title, description) VALUES (:title, :description)";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':title', $post['title']);
$stmt->bindParam(':description', $post['description']);

if($stmt->execute()) {
    echo "Dados inseridos com sucesso!";
} else {
    echo "Erro ao inserir dados.";
}

echo '<br><br> <a href="index.php">Voltar</a>';
```
----------------------- 
6. delete.php

```
<?php
include 'connect.php';
$id = filter_input(INPUT_GET, 'id');

$sql = "DELETE FROM products WHERE id = :id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->execute();
header("Location: select.php");
```
----------------------- 

7. update_form.php

```
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    include_once 'connect.php';
    $id = filter_input(INPUT_GET, 'id');
    $sql = "SELECT * FROM products WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    ?>
    <form action="update.php" method="post">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <label for="title">Título:</label>
        <input type="text" name="title" value="<?php echo $result['title']; ?>">
        <br>
        <br>

        <label for="description">Descrição:</label>
        <textarea name="description"><?php echo $result['description']; ?></textarea>
        <br>
        <br>

        <input type="submit" value="Submit">
    </form>
    <a href="index.php">Voltar</a>
</body>
</html>
```

----------------------- 
8. update.php

```
<?php
include 'connect.php';
$post = filter_input_array(INPUT_POST);
$sql = "UPDATE products SET title = :title, description = :description WHERE id = :id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':title', $post['title']);
$stmt->bindParam(':description', $post['description']);
$stmt->bindParam(':id', $post['id']);
if($stmt->execute()) {
    echo "Dados atualizados com sucesso!";
} else {
    echo "Erro ao atualizar dados.";
}

echo '<br><br> <a href="index.php">Voltar</a>';
```

---
9. select.php

```
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
    include_once 'connect.php';
?>

<table>
    <tr>
        <th>Id</th>
        <th>Título</th>
        <th>Descrição</th>
        <th> Editar </th>
        <th> Deletar </th>
    </tr>
    <?php
        $sql = "SELECT * FROM products";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($products as $product) {
          ?>
              <tr>
                <td><?php echo $product['id']; ?></td>
                <td><?php echo $product['title']; ?></td>
                <td><?php echo $product['description']; ?></td>
                <td><a href="#">Editar</a></td>
                <td><a href="#">Deletar</a></td>
              </tr>  
          <?php
        }
    ?>
</table>    
</body>
</html>
```