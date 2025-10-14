<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use App\Application\UserService;
use App\Domain\UserValidator;
use App\Infra\FileUserRepository;

$file = __DIR__ . '/../storage/user.txt';

$service = new UserService(new FileUserRepository($file), new UserValidator);

$userData = [
    'name' => $_POST['name'] ?? '',
    'email' => $_POST['email'] ?? '',
    'password' => $_POST['password'] ?? ''
];

$response = $service->register($userData);
$httpCode = $response ? 201 : 422;

http_response_code($httpCode);

echo $response ? 'Usuário cadastrado com sucesso!' : 'Falha no cadastro. Verifique os dados e tente novamente.';
echo '<br><br><a href="index.php">Voltar</a>';