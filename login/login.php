<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css">  
    <title>Tela Login</title>
</head>
<body>
    <img src="imagens/car10.png" alt="Imagem de fundo" id="background-image">
    <div class="main-login">
        <div class="card-login">
            <h1>JL<br>Deslocamentos</h1>
            <img src="imagens/bent.png" class="left-login-image" alt="imagem principal">
            
            <form action="logar.php" method="post">
                <h2>Login</h2>
                <div class="text-field">
                    <label  for="usuario">Usuário</label>
                    <input type="text" name="usuario" placeholder="Usuário"> 
                </div>
                <div class="text-field">
                    <label for="password">Senha</label>
                    <input type="password" name="password" placeholder="Senha">
                </div>
                <button class="btn-login" type="submit">Login</button>
            </form> 
        </div>
    </div>
    <div class="container">
    <footer>&copy; Darruiz 2023</footer>
</div>

</body>
</html>
