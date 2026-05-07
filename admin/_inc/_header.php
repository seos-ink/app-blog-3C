<nav id="sidebar">
        <div class="sidebar-header">
            <h4 class="fw-bold text-primary"><i class="bi bi-shield-lock-fill"></i> Admin </h4>
        </div>
        
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="<?= $base_url; ?>admin/home.php" class="nav-link">
                    <i class="bi bi-grid-1x2-fill"></i> Dashboard
                </a>
            </li>
                <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#userSubmenu" role="button" aria-expanded="true">
                    <i class="bi bi-people-fill"></i> 
                    <span>Usuários</span>
                    <i class="bi bi-chevron-down ms-auto small"></i>
                </a>
                <div class="collapse show" id="userSubmenu">
                    <ul class="submenu-list">
                        <li><a href="<?= $base_url; ?>admin/usuarios/form.php" class="submenu-link"><i class="bi bi-person-plus me-2"></i> Novo Usuário</a></li>
                        <li><a href="<?= $base_url; ?>admin/usuarios/index.php" class="submenu-link"><i class="bi bi-list-ul me-2"></i> Lista de Usuários</a></li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="bi bi-bag-check-fill"></i> Vendas
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="bi bi-gear-fill"></i> Ajustes
                </a>
            </li>
        </ul>
    </nav>

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
            /* min-height: 150px !important;
            max-height: 390px; */
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

        @media (max-width: 768px) {
            #sidebar { margin-left: -260px; }
            #main-content { margin-left: 0; }
        }
         /* Sidebar (Mantendo seu padrão) */
        /*#sidebar {
            width: 260px; height: 100vh; position: fixed; background: #fff;
            border-right: 1px solid rgba(0,0,0,0.05); transition: all 0.3s; z-index: 1000;
        }
        .sidebar-header { padding: 30px; text-align: center; }*/

        .nav-link {
            color: #dbdbdbff; padding: 12px 25px; margin: 5px 15px; border-radius: 10px;
            display: flex; align-items: center; font-weight: 500; transition: 0.3s; text-decoration: none;
        }

        .nav-link:hover, .nav-link.active {
            background-color: #0d6efd; color: #fff !important; box-shadow: 0 4px 12px rgba(13, 110, 253, 0.2);
        }

        .nav-link i { margin-right: 12px; font-size: 1.1rem; }
        
        .submenu-list { list-style: none; padding-left: 20px; margin-bottom: 10px; }

        .submenu-link {
            color: #d1d2d3ff; text-decoration: none; display: flex; align-items: center;
            padding: 8px 25px; font-size: 0.9rem; transition: 0.3s;
        }

        .submenu-link:hover { color: #3e8bffff; }
    </style>