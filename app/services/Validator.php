<?php
class Validator
{

  public static function validateEmail(array $input)
  {
    $errors = ['email' => ''];

    $values = [
      'email' => trim((string)($input['email'] ?? ''))
    ];

    if ($values['email'] === '') {
      $errors['email'] = "L'email est obligatoire.";
    } elseif (!filter_var($values['email'], FILTER_VALIDATE_EMAIL)) {
      $errors['email'] = "L'email n'est pas valide.";
    }

    $ok = $errors['email'] === '';

    return ['ok' => $ok, 'errors' => $errors, 'values' => $values];
  }

  public static function validateUsername(array $input)
  {
    $errors = ['username' => ''];

    $values = [
      'username' => trim((string)($input['username'] ?? ''))
    ];

    if ($values['username'] === '') {
      $errors['username'] = "Le nom d'utilisateur est obligatoire.";
    } elseif (mb_strlen($values['username']) < 2) {
      $errors['username'] = "Le nom d'utilisateur doit contenir au moins 2 caractères.";
    }

    $ok = $errors['username'] === '';

    return ['ok' => $ok, 'errors' => $errors, 'values' => $values];
  }
}
