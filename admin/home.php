<?php 
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: index.php');
    exit();
}
require_once '../conn/conect.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Dashboard</title>
    
    <link rel="stylesheet" href="<?= $base_url; ?>public/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    
</head>
<body>
    <?php include_once '_inc/_header.php'; ?>

    <main id="main-content">
        
        <div class="top-nav d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold text-secondary">Visão Geral</h5>
            <div class="d-flex align-items-center">
                <span class="me-3 small text-muted">Olá, <strong><?= $_SESSION['email']; ?></strong></span>
                <a href="index.php" class="btn btn-outline-danger btn-sm btn-logout">
                    <i class="bi bi-power"></i> Sair
                </a>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card card-custom p-4">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="text-muted small fw-bold mb-1">TOTAL VENDAS</p>
                            <h3 class="fw-bold mb-0">R$ 12.450</h3>
                        </div>
                        <div class="text-primary fs-1">
                            <i class="bi bi-graph-up-arrow"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-custom p-4">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="text-muted small fw-bold mb-1">NOVOS CLIENTES</p>
                            <h3 class="fw-bold mb-0">48</h3>
                        </div>
                        <div class="text-success fs-1">
                            <i class="bi bi-person-plus"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-custom p-4">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="text-muted small fw-bold mb-1">MENSAGENS</p>
                            <h3 class="fw-bold mb-0">12</h3>
                        </div>
                        <div class="text-warning fs-1">
                            <i class="bi bi-envelope-paper"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-custom mt-5">
            <div class="card-body p-0">
                <div class="p-4 border-bottom">
                    <h6 class="fw-bold mb-0">Atividades Recentes</h6>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 border-0">Cliente</th>
                                <th class="border-0">Serviço</th>
                                <th class="border-0">Status</th>
                                <th class="text-end pe-4 border-0">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary rounded-circle text-white d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px;">
                                            <i class="bi bi-person small"></i>
                                        </div>
                                        <span>Marcos Oliveira</span>
                                    </div>
                                </td>
                                <td>Assinatura Premium</td>
                                <td><span class="badge rounded-pill bg-success-subtle text-success border border-success">Concluído</span></td>
                                <td class="text-end pe-4">
                                    <button class="btn btn-sm btn-light border"><i class="bi bi-eye"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </main>

    <script src="<?= $base_url; ?>public/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>