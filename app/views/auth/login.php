<?php
function e($v)
{
  return htmlspecialchars($v ?? '', ENT_QUOTES, 'UTF-8');
}

function cls_invalid($errors, $field)
{
  return ($errors[$field] ?? '') !== '' ? 'is-invalid' : '';
}
?>
<!doctype html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Connexion | Plateforme Humanitaire</title>
  <meta name="description" content="Plateforme humanitaire pour les besoins des populations malgaches.">

  <!-- Fonts (Inter & Outfit) -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@500;700&display=swap" rel="stylesheet">

  <!-- Clean Icons (Bootstrap Icons) -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  <!-- Custom CSS System -->
  <link rel="stylesheet" href="/css/app.css">
  <link rel="stylesheet" href="/css/pages/auth.css">
</head>

<body class="login-page">

  <div class="login-box">

    <!-- Logo / Brand -->
    <div class="login-logo">
      <a href="/login">
        <i class="bi bi-heart-pulse-fill" style="color: var(--color-accent);"></i>
        SOS Cyclone
      </a>
    </div>

    <!-- Login Card -->
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">Connectez-vous pour accéder à la plateforme. <br>Ceci est une autologin.</p>

        <form action="/login" method="post">

          <div class="form-group">
            <label for="email" class="form-label">Email</label>
            <div class="input-group">
              <input type="email" name="email" id="email" class="form-control" placeholder="exemple@email.com" required>
              <div class="input-group-text"><i class="bi bi-envelope"></i></div>
            </div>
          </div>


          <div class="row align-items-center mb-3">
            <div class="col-8">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="rememberMe">
                <label class="form-check-label" for="rememberMe">
                  Se souvenir de moi
                </label>
              </div>
            </div>
            <div class="col-4 text-center">
              <button type="submit" class="btn btn-primary w-100">
                Entrer <i class="bi bi-arrow-right-short"></i>
              </button>
            </div>
          </div>

        </form>

        <div class="social-auth-links">
          <p class="text-center" style="font-size: 0.9em; opacity: 0.7;">- OU -</p>
          <a href="#" class="btn btn-outline mb-2 w-100">
            <i class="bi bi-facebook me-2"></i> Continuer avec Facebook
          </a>
          <a href="#" class="btn btn-outline w-100" style="color: #db4437; border-color: #db4437;">
            <i class="bi bi-google me-2"></i> Continuer avec Google
          </a>
        </div>

      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <!-- /.login-box -->


  <footer class="app-footer">
    <div class="container text-center">
      <p class="footer-numbers">4019-4090-4395</p>
      <p class="footer-copyright">&copy; 2026 SOS Cyclone. Tous droits réservés.</p>
    </div>
  </footer>

</body>

</html>