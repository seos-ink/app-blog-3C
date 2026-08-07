<?php 
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: index.php');
    exit();
}
require_once '../../conn/conect.php';

try {
    $sql = "SELECT U.*, L.name AS level_name 
            FROM users AS U 
            INNER JOIN level_users AS L ON U.id_level_users = L.id 
            ORDER BY U.name ASC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro na consulta: " . $e->getMessage());
}

include_once '../_inc/_header.php';
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

    <main id="main-content">

    <div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">Gerenciar Usuários</h4>
            <p class="text-muted small mb-0">Total de <?= count($users); ?> usuários cadastrados.</p>
        </div>
        <div>
            <a href="form.php" class="btn btn-primary px-5 shadow-sm">
                <i class="bi bi-plus-lg me-2"></i>Adicionar Novo
            </a>
        </div>
    </div>

    <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr class="text-muted small">
                                <th class="ps-4" style="width: 35%">NOME / E-MAIL</th>
                                <th style="width: 20%">NÍVEL</th>
                                <th style="width: 20%">SLUG</th>
                                <th style="width: 10%">STATUS</th>
                                <th class="text-end pe-4" style="width: 15%">AÇÕES</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <?php if (!empty($user['image'])): ?>
                                                <img src="<?= $user['image']; ?>" class="rounded me-3"
                                                    style="width: 50px; height: 50px; object-fit: cover;">
                                            <?php else: ?>
                                                <div class="bg-light border rounded me-3 d-flex align-items-center justify-content-center text-muted"
                                                    style="width: 50px; height: 50px;">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                            <?php endif; ?>

                                            <div>
                                                <div class="fw-bold text-dark"><?= htmlspecialchars($user['name']); ?></div>
                                                <div class="text-muted small text-truncate" style="max-width: 300px;">
                                                    <?= htmlspecialchars($user['email']); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span
                                            class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2 text-capitalize">
                                            <?= htmlspecialchars($user['level_name']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="text-muted small text-truncate" style="max-width: 200px;">
                                            <?= htmlspecialchars($user['slug'] ?? ''); ?>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="d-flex align-items-center">
                                            <span
                                                class="status-dot <?= $user['status'] == 1 ? 'bg-success' : 'bg-danger'; ?>"></span>
                                            <span
                                                class="small fw-bold <?= $user['status'] == 1 ? 'text-success' : 'text-danger'; ?>">
                                                <?= $user['status'] == 1 ? 'Ativo' : 'Inativo'; ?>
                                            </span>
                                        </span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group shadow-sm">
                                            <a href="form_update.php?id=<?= $user['id']; ?>"
                                                class="btn btn-white btn-sm border" title="Editar">
                                                <i class="fas fa-edit text-primary"></i>
                                            </a>
                                            <a href="javascript:void(0)" class="btn btn-white btn-sm border" title="Excluir"
                                                onclick="confirmarExclusao(<?= $user['id']; ?>, '<?= addslashes(htmlspecialchars($user['name'])); ?>')">
                                                <i class="fas fa-trash-alt text-danger"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                        </tbody>
                    </table>
                </div>
            </div>

     <div class="user-list mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="../home.php" class="btn btn-outline-secondary px-3">
                <i class="bi bi-arrow-left me-2"></i>Voltar para Dashboard
            </a>
     </div>

     </div>
        

    <?php include_once '../_inc/_footer.php'; ?>



    </main>

    <script src="<?= $base_url; ?>public/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- <script>
        (function(){
            const input = document.getElementById('inputGroupFile01');
            const fileInput = document.getElementById('inputLocalFile');
            const img = document.getElementById('imagePreview');
            const err = document.getElementById('imageError');

            function clearPreview(){
                if(img.src){
                    URL.revokeObjectURL(img.src);
                }
                img.src = '';
                img.style.display = 'none';
                err.style.display = 'none';
            }

            function showError(message){
                img.style.display = 'none';
                err.textContent = message;
                err.style.display = 'block';
            }

            function updatePreviewFromUrl(url){
                if(!url){
                    clearPreview();
                    return;
                }

                // Browsers não carregam `file://` em páginas servidas via http(s)
                if(url.startsWith('file://')){
                    clearPreview();
                    showError('O navegador não permite carregar arquivos locais via `file://`. Use o botão "Escolher arquivo" abaixo ou mova a imagem para o servidor e use um URL http/https.');
                    return;
                }

                err.style.display = 'none';
                img.style.display = 'block';
                img.src = url;
            }

            function updatePreviewFromFile(file){
                if(!file){
                    return updatePreviewFromUrl(input.value.trim());
                }

                // Limpa qualquer URL escrita
                input.value = '';
                err.style.display = 'none';
                const objectUrl = URL.createObjectURL(file);
                img.src = objectUrl;
                img.style.display = 'block';
            }

            img.addEventListener('error', function(){
                showError('Não foi possível carregar a imagem. Verifique a URL ou o arquivo.');
            });

            img.addEventListener('load', function(){
                err.style.display = 'none';
                img.style.maxHeight = '150px';
            });

            input.addEventListener('input', function(){
                // Se o usuário começar a digitar uma URL, limpa o file input
                if(fileInput) fileInput.value = '';
                updatePreviewFromUrl(input.value.trim());
            });

            if(fileInput){
                fileInput.addEventListener('change', function(e){
                    const file = e.target.files && e.target.files[0];
                    if(file){
                        updatePreviewFromFile(file);
                    } else {
                        // sem arquivo escolhido, tenta usar a URL escrita
                        updatePreviewFromUrl(input.value.trim());
                    }
                });
            }

            // Se já houver valor no input (edição), atualiza o preview
            if(input && input.value){
                updatePreviewFromUrl(input.value.trim());
            }
        })();
    </script> -->
</body>
</html>