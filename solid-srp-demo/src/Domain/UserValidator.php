<?php

declare(strict_types=1);

namespace App\Domain;

final class UserValidator
{
    /**
     * @param array{name?:string,email?:string,password?:string} $input
     */
    public function validate(array $input): array 
    {
        $errors = [];

        $email = $input['email'] ?? ''; // ?? -> null coalescing
        $password = $input['password'] ?? '';

        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $errors[] = 'E-mail inválido';
        }

        if (strlen($password) < 8) {
            $errors[] = 'Senha fraca (mínimo de 8 caracteres)';
        }

        return $errors;
    }
}
