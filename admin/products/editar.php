<?php include_once '../_inc/_header.php'; ?>

<?php
include '../../conn/conect.php';

$mensagem = "";
$produto = null;

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int)$_GET['id'];
    
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $produto = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$produto) {
        die("<div class='container-fluid mt-4'><div class='alert alert-danger'>Produto não encontrado.</div></div>");
    }
} else {
    die("<div class='container-fluid mt-4'><div class='alert alert-danger'>ID do produto inválido ou não fornecido.</div></div>");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    
    if (empty($post['nome']) || empty($post['preco'])) {
        $mensagem = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>Por favor, preencha o Nome e o Preço.</div>";
    } else {
        try {
            $id_update = (int)$post['id'];
            unset($post['id']);

            $table = 'products';
            $setFields = [];

            foreach ($post as $key => $value) {
                $setFields[] = $key . " = :" . $key;
            }

            $sql = "UPDATE " . $table . " SET " . implode(", ", $setFields) . " WHERE id = :id_where";
            $stmt = $pdo->prepare($sql);

            foreach ($post as $key => $value) {
                $stmt->bindValue(':' . $key, $value);
            }
            $stmt->bindValue(':id_where', $id_update, PDO::PARAM_INT);
            
            $stmt->execute();
            
            $mensagem = "<div class='alert alert-success alert-dismissible fade show' role='alert'>Produto atualizado com sucesso!</div>";
            $stmtRecarregar = $pdo->prepare("SELECT * FROM products WHERE id = :id");
            $stmtRecarregar->execute([':id' => $id_update]);
            $produto = $stmtRecarregar->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            $mensagem = "<div class='alert alert-danger text-start' role='alert'>Erro ao atualizar: " . $e->getMessage() . "</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Dashboard</title>
    
    <link rel="stylesheet" href="<?= $base_url; ?>public/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        body {
            background-color: #e4e4e4ff; /* Mesmo fundo do login */
            font-family: 'Segoe UI', Roboto, sans-serif;
        }

        /* Sidebar com estilo moderno */
        #sidebar {
            width: 260px;
            height: 100vh;
            position: fixed;
            background: #0c2746ff;
            border-right: 1px solid rgba(0,0,0,0.05);
            transition: all 0.3s;
        }

        .sidebar-header {
            padding: 30px;
            text-align: center;
        }

        .nav-link {
            color: #ffffffff;
            padding: 12px 25px;
            margin: 5px 15px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            font-weight: 500;
            transition: 0.3s;
        }

        .nav-link:hover, .nav-link.active {
            background-color: #3291bda9;
            color: #fff !important;
            border-radius: 25px;
            box-shadow: 0 2px 8px rgba(13, 109, 253, 0.56);
        }

        .nav-link i {
            margin-right: 12px;
            font-size: 1.1rem;
        }

        /* Área de Conteúdo */
        #main-content {
            margin-left: 260px;
            padding: 30px;
        }

        /* Estilo de Card "Login-like" */
        .card-custom {
            border: none;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
            background: #fff;
            transition: transform 0.3s;
        }

        .card-custom:hover {
            transform: translateY(-5px);
        }

        .top-nav {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.03);
            margin-bottom: 30px;
            padding: 15px 25px;
        }

        .btn-logout {
            border-radius: 8px;
            font-weight: 600;
        }
        .btn.btn-primary, .btn.btn-primary.px-5.shadow-sm {
            background-color: #0c2746ff;
            border: none;
            /* transition: background-color 0.3s, box-shadow 0.3s; */
        }
        .btn.btn-primary:hover {
            background-color: #0a1f3dff;
            box-shadow: 0 4px 12px rgba(12, 39, 70, 0.4);
        }
        .card.card-full {
            border-radius: 5px;
            border: 1px solid black;
        }

        @media (max-width: 768px) {
            #sidebar { margin-left: -260px; }
            #main-content { margin-left: 0; }
        }
        .form-control {
            width: 100%;
            /* padding: 10px; */
            margin: 5px 0 15px 0;
            border: 2px solid #ccc;
            border-radius: 10px;
            box-sizing: border-box;
        }
        .form-control:focus {
            border-color: #0f1318ff;
            box-shadow: 0 0 10px rgba(15, 19, 24, 0.5);
        }
        .form-select {
            width: 100%;
            /* padding: 10px; */
            margin: 5px 0 15px 0;
            border: 2px solid #ccc;
            border-radius: 10px;
            box-sizing: border-box;
        }
        .form-select:focus {
            border-color: #0f1318ff;
            box-shadow: 0 0 10px rgba(15, 19, 24, 0.5);
        }
        .form-check-input {
            width: 40px;
            height: 20px;
            border-radius: 10px;
            background-color: #ccc;
            transition: background-color 0.3s, box-shadow 0.3s;
        }
        .form-check-input:checked {
            background-color: #0c2746ff;
            box-shadow: 0 4px 12px rgba(12, 39, 70, 0.4);
        }
        .alert.alert-danger {
            background-color: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
            width: 80%;
            margin: 10px auto;
        }
        .alert.alert-success {
            background-color: #d4edda;
            border-color: #c3e6cb;
            color: #155724;
            width: 80%;
            margin: 20px auto;
        }
        /* .card-body {
            margin: 0px;
            padding: px !important;
        } */


    </style>
</head>
<body> 

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">Editar Produto #<?php echo $produto['id']; ?></h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb small mb-0">
                    <li class="breadcrumb-item"><a href="../home.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="index.php">Produtos</a></li>
                    <li class="breadcrumb-item active">Editar</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2">
            <a href="index.php" class="btn btn-outline-secondary px-3">
                <i class="fas fa-times me-2"></i>Cancelar
            </a>
            
            <button type="submit" form="formEditar" class="btn btn-primary px-4">
                <i class="fas fa-check me-2"></i>Salvar Alterações
            </button>
        </div>
    </div>

    <?php echo $mensagem; ?>

    <div class="card card-full">
        <div class="card-header bg-white py-3">
            <h6 class="fw-bold mb-0 text-dark">Dados do Produto</h6>
        </div>
        <div class="card-body p-4">
            <form action="" method="POST" id="formEditar">
                
                <input type="hidden" name="id" value="<?php echo $produto['id']; ?>">

                <div class="row g-4 mb-4">

                    <div class="col-md-4">
                        <label class="form-label fw-bold small text-muted text-uppercase">Nome do Produto *</label>
                        <input type="text" name="title" value="<?php echo htmlspecialchars($produto['title']); ?>" class="form-control form-control-flat" placeholder="Nome do Produto" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold small text-muted text-uppercase">Preço *</label>
                        <input type="text" name="description" class="form-control form-control-flat" value="<?php echo htmlspecialchars($produto['description']); ?>" placeholder="R$" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold small text-muted text-uppercase">Url da Imagem</label>
                        <input type="text" name="image" class="form-control form-control-flat mb-2" value="<?php echo htmlspecialchars($produto['image']); ?>" placeholder="https://linkdaimagem.com">

                        <?php 
                        if (!empty($produto['image'])) {
                            echo "<div class='mt-2'><span class='small text-muted d-block fw-bold mb-1'>Imagem Atual:</span><img src='" . $produto['image'] . "' alt='avatar' style='width: 100px; height: 100px; object-fit: cover;' class='img-thumbnail'/></div>";
                        }
                        ?>
                    </div>
                   
                </div>

            </form>
        </div>
        <div class="card-footer bg-light py-3 d-flex justify-content-end gap-2">
            <span class="text-muted small align-self-center me-auto ms-2">Campos marcados com * são obrigatórios</span>
            <button type="submit" form="formEditar" class="btn btn-primary px-5 shadow-sm">
                Salvar Alterações
            </button>
        </div>
    </div>
</div>

<?php include_once '../_inc/_footer.php'; ?>