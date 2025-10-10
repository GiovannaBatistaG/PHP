<?php

declare(strict_types=1);

namespace App\Application;

use App\Domain\UserRepository;
use App\Domain\UserValidator;

class ListUserService
{
  private UserRepository $repository;

  public function __construct(UserRepository $repository)
  {
    $this->repository = $repository;
  }

  /**
     * @return array<int, array{name:string,email:string,password:string}>
     */
    public function findAll(): array
    {
      return $this->repository->findAll();
    }
}

?>
