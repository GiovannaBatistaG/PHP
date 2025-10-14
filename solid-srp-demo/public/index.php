<?php
declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <h1>Cadastro de Alunos</h1>
  <form action="register.php" method="post">
    <label for="name">Nome:</label>
    <input type="text" name="name" id="name">
    <label for="email">Email:</label>
    <input type="email" name="email" id="email">
    <label for="password">Senha:</label>
    <input type="password" name="password" id="password">
    <button type="submit">Cadastrar</button>
  </form>
  
  <h1>Lista de Alunos</h1>
  <form action="users.php" method="get">
    <button type="submit">Exibir Alunos</button>
  </form>
</body>
</html>