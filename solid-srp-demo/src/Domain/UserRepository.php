<?php

declare(strict_types=1);

namespace App\Domain;

interface UserRepository
{
    /**
     * @param array{name:string,email:string,password:string} $user
     */
    public function save(array $user): void;

    public function findAll(): array;

    /**
     * @param string $email
     * @return array{name:string,email:string,password:string}|null
     */
    public function findByEmail(string $email): ?array;
}
