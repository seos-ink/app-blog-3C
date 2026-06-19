<?php 
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: index.php');
    exit();
}
require_once '../../conn/conect.php';
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


    </style>
</head>
<body> 

    <?php include_once '../_inc/_header.php'; ?>
    <main id="main-content">

    <div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">Novo Usuário</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb small mb-0">
                    <li class="breadcrumb-item"><a href="../home.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="index.php">Usuários</a></li>
                    <li class="breadcrumb-item active">Cadastro</li>
                </ol>
            </nav>
        </div>
        <!-- <div class="d-flex gap-2">
            <a href="index.php" class="btn btn-outline-secondary px-3">
                <i class="fas fa-times me-2"></i>Cancelar
            </a>
            <button type="submit" form="formCadastro" class="btn btn-primary px-4">
                <i class="fas fa-check me-2"></i>Salvar Registro
            </button>
        </div> -->
    </div>

    <div class="card card-full">
        <div class="card-header bg-white py-3">
            <h6 class="fw-bold mb-0 text-dark">Cadastro</h6>
        </div>

            <?php if(isset($_GET['errornull'])): ?>
                <div class="alert alert-danger" role="alert">
                    <strong>Erro!</strong> Todos os campos são obrigatórios.
                </div>
            <?php endif; ?>

            <?php if(isset($_GET['errorhash'])): ?>
                <div class="alert alert-danger" role="alert">
                    <strong>Erro!</strong> As senhas não conferem.
                </div>
            <?php endif; ?>

            <?php if(isset($_GET['success'])): ?>
                <div class="alert alert-success" role="alert">
                    Usuário cadastrado com sucesso.
                </div>
            <?php endif; ?>

        <div class="card-body p-4">
            <form action="insert.php" method="POST" id="formCadastro" enctype="multipart/form-data">

                <div class="row g-4 mb-4">
                    <div class="col-md-4">
                        <label class="form-label fw-bold small text-muted text-uppercase">Nome Completo *</label>
                        <input type="text" name="name" class="form-control form-control-flat" placeholder="Digite o nome" >
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold small text-muted text-uppercase">E-mail Principal *</label>
                        <input type="email" name="email" class="form-control form-control-flat" placeholder="exemplo@blog.com" >
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold small text-muted text-uppercase">Nível de Permissão *</label>

                        <select name="id_level_users" class="form-select form-control-flat">
                            <?php
                            // Select de dados da tabela level_users
                            $stmt = $pdo->prepare("Select *from level_users");
                            $stmt->execute();
                            foreach($stmt as $row) {
                                echo '<option value="'.$row['id'].'">' . $row['name'] . '</option>';
                            }
                            ?>
                        </select>

                    </div>

                    <div class="col-md-6" style="display: flex; flex-direction: column; justify-content: center; align-items: center;">
                        <label class="form-label fw-bold small text-muted text-uppercase" for="inputGroupFile01">Imagem</label>
                        <input type="text" class="form-control" name="image" id="inputGroupFile01" placeholder="URL da imagem" />
                        <div class="img-preview" style="display: flex; flex-direction: column; justify-content: center; align-items: center; border: 1px solid #ccc; border-radius: 7px; padding: 0px; margin-top: 10px;">
                            <img id="imagePreview" src="" alt="Preview da Imagem" class="img-fluid rounded" style="display:none; max-height: 150px;">
                            <div id="imageError" class="text-danger small mt-2" style="display:none">Não foi possível carregar a imagem.</div>
                        </div>
                        <!-- <input type="file" class="form-control mt-2" id="inputLocalFile" accept="image/*" /> -->
                    </div>
                </div>

                <div class="row g-4 mb-4">
                    <div class="col-md-4">
                        <label class="form-label fw-bold small text-muted text-uppercase">Senha de Acesso *</label>
                        <input type="password" name="password" class="form-control form-control-flat" placeholder="••••••••" >
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold small text-muted text-uppercase">Confirmar Senha *</label>
                        <input type="password" name="pass_confirm" class="form-control form-control-flat" placeholder="••••••••" >
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold small text-muted text-uppercase">Telefone *</label>
                        <input type="tel" pattern="\(\d{2}\)\s\d{5}-\d{4}" id="phone" name="phone" pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}" class="form-control form-control-flat" placeholder="(12) 999999-9999">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold small text-muted text-uppercase">Slug *</label>
                        <input type="text" class="form-control form-control-flat" placeholder="Ex.: fulano-de-tal" name="slug">
                    </div>                                    
                    <div class="col-md-4">
                        <label class="form-label fw-bold small text-muted text-uppercase">Status da Conta *</label>
                        <div class="d-flex align-items-center h-100 mt-2">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="statusSwitch" name="status" checked>
                                <label class="form-check-label ms-2" for="statusSwitch">Usuário Ativo</label>
                            </div>
                        </div>
                    </div>
                </div>               

            </form>
        </div>
        <div class="card-footer bg-light py-3 d-flex justify-content-end gap-2">
            <span class="text-muted small align-self-center me-auto ms-2">Campos marcados com * são obrigatórios</span>
            <button type="submit" form="formCadastro" class="btn btn-primary px-5 shadow-sm">
                Salvar Novo Usuário
            </button>
        </div>
    </div>

    <div class="user-list mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="index.php" class="btn btn-outline-secondary px-3">
                <i class="bi bi-arrow-left me-2"></i>Voltar para Lista
            </a>
    </div>

</div>



<?php include_once '../_inc/_footer.php'; ?>



    </main>

    <script src="<?= $base_url; ?>public/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
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
    </script>
</body>
</html>