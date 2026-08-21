<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: index.php');
    exit();
}
require_once '../../conn/conect.php';

try {
    $sql = "SELECT * FROM blogs ORDER BY id DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $blogs = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
            background-color: #e4e4e4ff;
            /* Mesmo fundo do login */
            font-family: 'Segoe UI', Roboto, sans-serif;
        }

        /* Sidebar com estilo moderno */
        #sidebar {
            width: 260px;
            height: 100vh;
            position: fixed;
            background: #0c2746ff;
            border-right: 1px solid rgba(0, 0, 0, 0.05);
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

        .nav-link:hover,
        .nav-link.active {
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
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
            margin-bottom: 30px;
            padding: 15px 25px;
        }

        .btn-logout {
            border-radius: 8px;
            font-weight: 600;
        }

        .btn.btn-primary,
        .btn.btn-primary.px-5.shadow-sm {
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
            #sidebar {
                margin-left: -260px;
            }

            #main-content {
                margin-left: 0;
            }
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
                    <h4 class="fw-bold mb-0">Gerenciar Posts do Blog</h4>
                    <p class="text-muted small mb-0">Total de <?= count($blogs); ?> posts cadastrados.</p>
                </div>
                <a href="form.php" class="btn btn-primary shadow-sm px-4">
                    <i class="fas fa-plus me-2"></i>Adicionar
                </a>
            </div>

            <div class="card card-full border-0 shadow-sm">
                <?php if (isset($_GET['deleted'])): ?>
                    <div class="alert alert-success m-3" role="alert">Blog excluído com sucesso!</div>
                <?php endif; ?>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr class="text-muted small">
                                    <th class="ps-4" style="width: 40%">TÍTULO / SUBTÍTULO</th>
                                    <th style="width: 25%">SLUG</th>
                                    <th style="width: 15%">STATUS</th>
                                    <th class="text-end pe-4" style="width: 20%">AÇÕES</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (count($blogs) > 0): ?>
                                    <?php foreach ($blogs as $blog): ?>
                                        <tr>
                                            <td class="ps-4">
                                                <div class="d-flex align-items-center">
                                                    <?php if (!empty($blog['image'])): ?>
                                                        <img src="<?= $blog['image']; ?>" class="rounded me-3"
                                                            style="width: 50px; height: 50px; object-fit: cover;">
                                                    <?php else: ?>
                                                        <div class="bg-light border rounded me-3 d-flex align-items-center justify-content-center text-muted"
                                                            style="width: 50px; height: 50px;">
                                                            <i class="fas fa-image"></i>
                                                        </div>
                                                    <?php endif; ?>

                                                    <div>
                                                        <div class="fw-bold text-dark">
                                                            <?= htmlspecialchars($blog['title']); ?>
                                                        </div>
                                                        <div class="text-muted small text-truncate" style="max-width: 300px;">
                                                            <?= htmlspecialchars($blog['subtitle'] ?? ''); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="text-muted small text-truncate" style="max-width: 200px;">
                                                    <?= htmlspecialchars($blog['slug'] ?? ''); ?>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="d-flex align-items-center">
                                                    <span
                                                        class="status-dot <?= $blog['status'] == 1 ? 'bg-success' : 'bg-danger'; ?>"></span>
                                                    <span
                                                        class="small fw-bold <?= $blog['status'] == 1 ? 'text-success' : 'text-danger'; ?>">
                                                        <?= $blog['status'] == 1 ? 'Ativo' : 'Inativo'; ?>
                                                    </span>
                                                </span>
                                            </td>
                                            <td class="text-end pe-4">
                                                <div class="btn-group shadow-sm">
                                                    <a href="form_update.php?id=<?= $blog['id']; ?>"
                                                        class="btn btn-white btn-sm border" title="Editar">
                                                        <i class="bi bi-pencil-square"></i> Editar
                                                    </a>
                                                    <a href="javascript:void(0)" class="btn btn-white btn-sm border"
                                                        title="Excluir"
                                                        onclick="confirmarExclusao(<?= $blog['id']; ?>, '<?= addslashes(htmlspecialchars($blog['title'])); ?>')">
                                                        <i class="bi bi-exclamation-diamond"></i> Excluir
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center py-5 text-muted">
                                            Nenhum post encontrado no banco de dados.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmarExclusao(id, nome) {
            Swal.fire({
                title: 'Tem certeza?',
                text: `Você deseja excluir o blog: ${nome}?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sim, excluir!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `delete.php?id=${id}`;
                }
            })
        }
    </script>
</body>

</html>