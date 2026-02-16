<?php
class UserRepository
{
  private $pdo;
  public function __construct(PDO $pdo)
  {
    $this->pdo = $pdo;
  }

  public function findById($id)
  {
    $st = $this->pdo->prepare("SELECT * FROM users WHERE iduser = ? LIMIT 1");
    $st->execute([(int)$id]);
    return $st->fetch(PDO::FETCH_ASSOC);
  }

  public function findByEmail($email)
  {
    $st = $this->pdo->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
    $st->execute([(string)$email]);
    return $st->fetch(PDO::FETCH_ASSOC);
  }

  public function create($email)
  {
    $st = $this->pdo->prepare("INSERT INTO users(email) VALUES(?)");
    $st->execute([(string)$email]);
    return $this->pdo->lastInsertId();
  }
}
