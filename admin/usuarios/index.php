<?php 
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: index.php');
    exit();
}
require_once '../../conn/conect.php';

// <?php
// require_once '../../_conn/conect.php';
// try {
//     $sql = "SELECT U.*, L.name AS level_name 
//             FROM users AS U 
//             INNER JOIN level_users AS L ON U.id_level_users = L.id 
//             ORDER BY U.name ASC";
//     $stmt = $pdo->prepare($sql);
//     $stmt->execute();
//     $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
// } catch (PDOException $e) {
//     die("Erro na consulta: " . $e->getMessage());
// }
// include_once '../_inc/_header.php';
// foreach ($users as $user):
//     echo $user['name'];
// endforeach;
// ?>

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
            <h4 class="fw-bold mb-0">Lista de Usuários</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb small mb-0">
                    <li class="breadcrumb-item"><a href="../home.php">Home</a></li>
                    <li class="breadcrumb-item active">Usuários</li>
                </ol>
            </nav>
        </div>
        <div>
            <a href="form.php" class="btn btn-primary px-5 shadow-sm">
                <i class="bi bi-plus-lg me-2"></i>Adicionar Novo
            </a>
        </div>
    </div>

    <div class="card card-list" style="border-radius: 10px; border: 1px solid darkslategray;">
        <div class="card-body p-4">
            <table class="table table-hover" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stmt = $pdo->query("SELECT U.*, L.name AS level_name FROM users AS U
                                         INNER JOIN level_users AS L ON U.id_level_users = L.id
                                         ORDER BY U.name ASC");
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                        echo "<td>" . ($row['status'] ? 'Ativo' : 'Inativo') . "</td>";
                        echo "<td><a href='form.php?id=" . $row['id'] . "' class='btn btn-sm btn-outline-primary'>Editar</a></td>";
                        echo "</tr>";
                    }
                    ?>
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