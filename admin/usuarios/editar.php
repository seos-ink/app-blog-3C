<?php

require_once "../../conn/conect.php";

$sql = "SELECT 
            u.*,
            l.name AS level_name
        FROM users u
        INNER JOIN level_users l 
            ON u.id_level_users = l.id
        WHERE u.id = :id
        LIMIT 1";

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $_GET['id']);
$stmt->execute();

$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

$sqlLevel = "SELECT id, name 
             FROM level_users 
             ORDER BY name ASC";

$stmtLevel = $pdo->prepare($sqlLevel);
$stmtLevel->execute();

$niveis = $stmtLevel->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuário - Painel Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            background: #f4f6f9;
            font-family: Arial, Helvetica, sans-serif;
            color: #1f2937;
        }

        .pagina {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 20px;
        }

        /*
        |--------------------------------------------------------------------------
        | Container principal
        |--------------------------------------------------------------------------
        */

        .editor-container {
            width: 100%;
            max-width: 1050px;
            background: #ffffff;
            border: 1px solid #e1e5ea;
            border-radius: 18px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        /*
        |--------------------------------------------------------------------------
        | Cabeçalho
        |--------------------------------------------------------------------------
        */

        .editor-header {
            padding: 28px 35px;
            border-bottom: 1px solid #e9ecef;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .header-icon {
            width: 58px;
            height: 58px;
            border-radius: 14px;
            background: #0d6efd;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 27px;
        }

        .header-title h1 {
            margin: 0;
            font-size: 23px;
            font-weight: 700;
        }

        .header-title p {
            margin: 4px 0 0;
            color: #6c757d;
            font-size: 14px;
        }

        .user-id {
            background: #f1f3f5;
            padding: 8px 13px;
            border-radius: 8px;
            font-size: 13px;
            color: #6c757d;
        }

        /*
        |--------------------------------------------------------------------------
        | Corpo
        |--------------------------------------------------------------------------
        */

        .editor-body {
            padding: 35px;
        }

        .section-title {
            font-size: 15px;
            font-weight: 700;
            color: #495057;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .section-title i {
            color: #0d6efd;
        }

        /*
        |--------------------------------------------------------------------------
        | Avatar / imagem
        |--------------------------------------------------------------------------
        */

        .profile-box {
            background: #f8f9fa;
            border: 1px solid #e5e7eb;
            border-radius: 13px;
            padding: 20px;
            height: 100%;
        }

        .profile-image {
            width: 105px;
            height: 105px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #ffffff;
            box-shadow: 0 3px 12px rgba(0, 0, 0, .12);
            display: block;
            margin: 0 auto 15px;
        }

        .profile-placeholder {
            width: 105px;
            height: 105px;
            border-radius: 50%;
            background: #e9ecef;
            color: #6c757d;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 35px;
            margin: 0 auto 15px;
        }

        .profile-name {
            text-align: center;
            font-weight: 600;
            font-size: 16px;
        }

        .profile-level {
            text-align: center;
            color: #6c757d;
            font-size: 13px;
            margin-top: 3px;
        }

        /*
        |--------------------------------------------------------------------------
        | Inputs
        |--------------------------------------------------------------------------
        */

        .form-label {
            font-size: 13px;
            font-weight: 600;
            color: #495057;
            margin-bottom: 7px;
        }

        .input-group-text {
            background: #ffffff;
            border-color: #dee2e6;
            color: #6c757d;
        }

        .form-control,
        .form-select {
            min-height: 43px;
            border-color: #dee2e6;
            font-size: 14px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #86b7fe;
            box-shadow: 0 0 0 .2rem rgba(13, 110, 253, .12);
        }

        .campo {
            margin-bottom: 20px;
        }

        /*
        |--------------------------------------------------------------------------
        | Senha
        |--------------------------------------------------------------------------
        */

        .password-info {
            font-size: 12px;
            color: #6c757d;
            margin-top: 5px;
        }

        /*
        |--------------------------------------------------------------------------
        | Rodapé
        |--------------------------------------------------------------------------
        */

        .editor-footer {
            padding: 22px 35px;
            border-top: 1px solid #e9ecef;
            background: #fafbfc;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .btn-cancelar {
            border: 1px solid #dc3545;
            color: #dc3545;
            background: white;
            padding: 9px 20px;
            border-radius: 7px;
        }

        .btn-cancelar:hover {
            background: #dc3545;
            color: white;
        }

        .btn-salvar {
            background: #0d6efd;
            color: white;
            border: none;
            padding: 10px 24px;
            border-radius: 7px;
        }

        .btn-salvar:hover {
            background: #0b5ed7;
            color: white;
        }

        /*
        |--------------------------------------------------------------------------
        | Responsividade
        |--------------------------------------------------------------------------
        */

        @media (max-width: 768px) {

            .pagina {
                padding: 15px;
                align-items: flex-start;
            }

            .editor-header {
                padding: 22px;
                align-items: flex-start;
            }

            .user-id {
                display: none;
            }

            .editor-body {
                padding: 22px;
            }

            .editor-footer {
                padding: 18px 22px;
                gap: 10px;
            }

            .btn-cancelar,
            .btn-salvar {
                width: 100%;
            }

            .editor-footer {
                flex-direction: column-reverse;
            }

        }
    </style>
</head>

<body>

    <div class="pagina">
        <div class="editor-container">
            <div class="editor-header">
                <div class="header-left">
                    <div class="header-icon">
                        <i class="bi bi-person-gear"></i>
                    </div>
                    <div class="header-title">
                        <h1>Editar usuário</h1>
                        <p>
                            Altere as informações da conta
                        </p>
                    </div>
                </div>
                <div class="user-id">
                    ID #<?= $usuario['id'] ?>
                </div>
            </div>

            <form action="atualizar.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= htmlspecialchars($usuario['id']) ?>">
                <div class="editor-body">
                    <div class="row g-4">
                        <div class="col-lg-3">
                            <div class="profile-box">
                                <div class="img-preview"
                                    style="display: flex; flex-direction: column; justify-content: center; align-items: center; padding: 0px; max-height: 150px; margin-top: 10px;">
                                    <img id="imagePreview" src="" alt="Preview da Imagem" class="img-fluid"
                                        style="display:none; max-height: 150px; border-radius: 80px; border: 3px solid #818181; padding: 0px;">
                                    <div id="imageError" class="text-danger small mt-2" style="display:none">Não foi
                                        possível carregar a imagem.</div>
                                </div>

                                <div class="profile-name">
                                    <?= htmlspecialchars($usuario['name']) ?>
                                </div>
                                <div class="profile-level">
                                    <?= htmlspecialchars($usuario['level_name']) ?>
                                </div>
                                <hr>

                                <label class="form-label">
                                    Alterar imagem
                                </label>
                                <input type="text" class="form-control" name="image" id="inputGroupFile01"
                                    placeholder="URL da imagem" value="<?= htmlspecialchars($usuario['image']) ?>" />
                                <small class="text-muted d-block mt-2">
                                    Deixe vazio para manter a imagem atual.
                                </small>
                            </div>
                        </div>

                        <div class="col-lg-9">
                            <div class="section-title">
                                <i class="bi bi-person-vcard"></i>
                                Informações da conta
                            </div>
                            <div class="campo">
                                <label class="form-label">
                                    Nome
                                </label>

                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-person"></i>
                                    </span>

                                    <input type="text" name="name" class="form-control"
                                        value="<?= htmlspecialchars($usuario['name']) ?>" placeholder="Nome completo"
                                        required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="campo">
                                        <label class="form-label">
                                            E-mail
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="bi bi-envelope"></i>
                                            </span>
                                            <input type="email" name="email" class="form-control"
                                                value="<?= htmlspecialchars($usuario['email']) ?>" placeholder="E-mail"
                                                required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="campo">
                                        <label class="form-label">
                                            Telefone
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="bi bi-telephone"></i>
                                            </span>
                                            <input type="text" name="telefone" class="form-control"
                                                value="<?= htmlspecialchars($usuario['phone']) ?>"
                                                placeholder="(00) 00000-0000">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="campo">
                                <label class="form-label">
                                    Slug
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-link-45deg"></i>
                                    </span>

                                    <input type="text" name="slug" class="form-control"
                                        value="<?= htmlspecialchars($usuario['slug']) ?>" placeholder="slug-do-usuario"
                                        required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="campo">
                                        <label class="form-label">
                                            Nova senha
                                        </label>

                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="bi bi-key"></i>
                                            </span>

                                            <input type="password" name="pass" class="form-control"
                                                placeholder="Nova senha">

                                        </div>
                                        <div class="password-info">
                                            Deixe vazio para manter a senha atual.
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="campo">
                                        <label class="form-label">
                                            Confirmar nova senha
                                        </label>

                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="bi bi-key-fill"></i>
                                            </span>

                                            <input type="password" name="pass_confirm" class="form-control"
                                                placeholder="Confirme a nova senha">
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-6">
                                    <div class="campo">
                                        <label class="form-label">
                                            Status
                                        </label>

                                        <select name="status" class="form-select" required>
                                            <option value="1" <?= $usuario['status'] == 1 ? 'selected' : '' ?>>
                                                Ativo
                                            </option>

                                            <option value="0" <?= $usuario['status'] == 0 ? 'selected' : '' ?>>
                                                Inativo
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="campo">
                                        <label class="form-label">
                                            Nível de acesso
                                        </label>
                                        <select name="level" class="form-select" required>

                                            <?php foreach ($niveis as $nivel): ?>
                                                <option value="<?= htmlspecialchars($nivel['id']) ?>"
                                                    <?= $usuario['id_level_users'] == $nivel['id'] ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($nivel['name']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="editor-footer">
                    <a href="index.php" class="btn btn-cancelar">
                        <i class="bi bi-arrow-left"></i>
                        Voltar
                    </a>

                    <button type="submit" class="btn btn-salvar">
                        <i class="bi bi-check-circle"></i>
                        Salvar alterações
                    </button>
                </div>
            </form>
        </div>
    </div>

</body>

<script>
    (function () {
        const input = document.getElementById('inputGroupFile01');
        const fileInput = document.getElementById('inputLocalFile');
        const img = document.getElementById('imagePreview');
        const err = document.getElementById('imageError');

        function clearPreview() {
            if (img.src) {
                URL.revokeObjectURL(img.src);
            }
            img.src = '';
            img.style.display = 'none';
            err.style.display = 'none';
        }

        function showError(message) {
            img.style.display = 'none';
            err.textContent = message;
            err.style.display = 'block';
        }

        function updatePreviewFromUrl(url) {
            if (!url) {
                clearPreview();
                return;
            }

            // Browsers não carregam `file://` em páginas servidas via http(s)
            if (url.startsWith('file://')) {
                clearPreview();
                showError('O navegador não permite carregar arquivos locais via `file://`. Use o botão "Escolher arquivo" abaixo ou mova a imagem para o servidor e use um URL http/https.');
                return;
            }

            err.style.display = 'none';
            img.style.display = 'block';
            img.src = url;
        }

        function updatePreviewFromFile(file) {
            if (!file) {
                return updatePreviewFromUrl(input.value.trim());
            }

            // Limpa qualquer URL escrita
            input.value = '';
            err.style.display = 'none';
            const objectUrl = URL.createObjectURL(file);
            img.src = objectUrl;
            img.style.display = 'block';
        }

        img.addEventListener('error', function () {
            showError('Não foi possível carregar a imagem. Verifique a URL ou o arquivo.');
        });

        img.addEventListener('load', function () {
            err.style.display = 'none';
            img.style.maxHeight = '150px';
        });

        input.addEventListener('input', function () {
            // Se o usuário começar a digitar uma URL, limpa o file input
            if (fileInput) fileInput.value = '';
            updatePreviewFromUrl(input.value.trim());
        });

        if (fileInput) {
            fileInput.addEventListener('change', function (e) {
                const file = e.target.files && e.target.files[0];
                if (file) {
                    updatePreviewFromFile(file);
                } else {
                    // sem arquivo escolhido, tenta usar a URL escrita
                    updatePreviewFromUrl(input.value.trim());
                }
            });
        }

        // Se já houver valor no input (edição), atualiza o preview
        if (input && input.value) {
            updatePreviewFromUrl(input.value.trim());
        }
    })();
</script>

</html>