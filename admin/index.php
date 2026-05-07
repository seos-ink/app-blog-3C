<?php
require_once '../conn/conect.php';

$error = isset($_GET['error']) ? true : false;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="<?= $base_url; ?>public/bootstrap/css/bootstrap.min.css">
    
</head>

<body>

    <!-- Formulário Login e Senha -->
    <div class="container mt-5" >
        <img src="../public/admin/images/person-badge.svg" alt="Login Image" style="display: block; margin: 0 auto 20px auto; width: 80px;">
        <h2 class="mb-4" style="text-align: center;">Entrar como Admin</h2>
        
        <?php if ($error): ?>
            <div class="alert alert-danger" role="alert">
                <img src="../public/admin/images/exclamation-triangle.svg" 
                     alt="" style="width: 30px; float: left; margin: 15px;">
                Usuário ou senha inválidos! Se o erro persistir, tente novamente mais tarde.
            </div>
        <?php endif; ?>

        <form action="logar.php" method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Usuário</label>
                <input type="text" class="form-control" id="username" name="email" required>
            </div>
            <div class="mb-3">                
                <label for="password" class="form-label">Senha</label>
                <div class="input-group">
                    <span class="input-group-text" id="togglePassword" style="cursor: pointer;">
                        <i class="bi bi-eye"></i>
                    </span>
                <input type="password" class="form-control" id="password" name="password" required>
                
            </div>
            <button type="submit" class="btn btn-primary">Entrar</button>
        </form>

    <style>
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
        .btn.btn-primary{
            transition: ease 0.3s;
            background-color: #07080aff;
            border: none;
            /* align-items: center; */
            display: flex;
            justify-content: center;
            width: 100%;
            padding: 10px;
            border-radius: 10px;
            font-size: 16px;
            font-weight: bold;
        }
        .btn.btn-primary:hover{
            transition: ease 0.3s;
            background-color: #071e85ff;
            border: none;
            align-items: center;
            display: flex;
            justify-content: center;
            width: 100%;
            border-radius: 25px;
        }
        body {
            background-color: #0f1318ff;
            /* background-image: url('../public/admin/images/js_.gif');
            background-size: cover; */
            align-items: center;
            display: flex;
            justify-content: center;
            height: 100vh;
            font-family: Arial, sans-serif;
        }
        .container {
            align-items: center;
            max-width: 350px;
            max-height: 550px;
            background-color: #fff;
            padding: 20px;
            margin: 50px;
            border: 2px solid #4b4b4bff;
            border-radius: 15px;
            box-shadow: 10px 10px 10000px rgba(6, 71, 212, 1);
        }
        .input-group, .input-group span{
            display: flex;
            align-items: center;
            height: 100%;
            
        }
    </style>

    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');
        const icon = togglePassword.querySelector('i');

        togglePassword.addEventListener('click', function () {
            const isPassword = password.getAttribute('type') === 'password';
            password.setAttribute('type', isPassword ? 'text' : 'password');
            icon.classList.toggle('bi-eye');
            icon.classList.toggle('bi-eye-slash');
        });
    </script>



</body>

</html>