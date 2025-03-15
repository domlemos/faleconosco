<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Document</title>
</head>
<body>
    <h1>Yetz Desk</h1>
        <p>Olá, {{ $user['name'] }}! Seja bem-vindo ao Yetz Desk. Para acessar o sistema, clique no link abaixo.</p>
        <p>Seu login é: {{ $user['email'] }}, e sua senha inicial é {{ $user['password'] }}</p>
        <p>A senha que você recebeu irá expirar e precisará ser recadastrada no primeiro acesso.</p>
        <p>Para acessar o sistema, clique no link abaixo:</p>
        <a href="http://localhost:5173/auth/login">Acessar o sistema YetzDesk</a>
</body>
</html>
