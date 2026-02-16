<?php
class UserService
{
  private $repo;
  public function __construct(UserRepository $repo)
  {
    $this->repo = $repo;
  }

  public function createUser($email)
  {
    return $this->repo->create($email);
  }

  public function findOrCreateUser($email)
  {
    $user = $this->repo->findByEmail($email);

    if ($user) {
      return $user;
    }

    $userId = $this->repo->create($email);
    return $this->repo->findByEmail($email);
  }
}
