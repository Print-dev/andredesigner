<?php session_start();
extract($_REQUEST); ?>
<!DOCTYPE html>
<html lang="es">
<?php error_reporting(E_ALL & ~E_NOTICE);
error_reporting(E_ERROR);
include "cn.php"; ?>

<head>
  <?php $_SESSION['reseller'] = $r; ?>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
  <title>Login - Andre's Design</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&display=swap" rel="stylesheet">
  <link rel="icon" type="image/png" href="https://res.cloudinary.com/dynpy0r4v/image/upload/v1742818076/vegaimagenes/esawybumfjhhujupw5pa.png">

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Montserrat', sans-serif;
      background: #222222;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
    }

    .login-container {
      display: flex;
      max-width: 1000px;
      width: 100%;
      background: white;
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
      min-height: 600px;
    }

    .left-section {
      flex: 1;
      background: black;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 60px 40px;
      position: relative;
      overflow: hidden;
    }

    @keyframes moveBackground {
      0% { transform: translate(0, 0); }
      100% { transform: translate(30px, 30px); }
    }

    .logo-container {
      position: relative;
      z-index: 1;
      text-align: center;
    }

    .logo-container img {
      width: 200px;
      height: 200px;
      object-fit: contain;
      filter: drop-shadow(0 10px 30px rgba(0, 0, 0, 0.3));
      animation: float 3s ease-in-out infinite;
    }

    @keyframes float {
      0%, 100% { transform: translateY(0px); }
      50% { transform: translateY(-20px); }
    }

    .logo-container h2 {
      color: white;
      font-size: 32px;
      font-weight: 700;
      margin-top: 30px;
      text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    }

    .logo-container p {
      color: rgba(255, 255, 255, 0.9);
      font-size: 16px;
      margin-top: 10px;
    }

    .right-section {
      flex: 1;
      padding: 60px 50px;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .form-header {
      margin-bottom: 40px;
    }

    .form-header h1 {
      color: #333;
      font-size: 32px;
      font-weight: 700;
      margin-bottom: 10px;
    }

    .form-header p {
      color: #666;
      font-size: 16px;
    }

    .field-wrap {
      margin-bottom: 25px;
    }

    .field-wrap label {
      display: block;
      color: #555;
      font-size: 14px;
      font-weight: 500;
      margin-bottom: 8px;
    }

    .field-wrap label .req {
      color: #e74c3c;
      margin-left: 3px;
    }

    .field-wrap input {
      width: 100%;
      padding: 15px 20px;
      border: 2px solid #e0e0e0;
      border-radius: 10px;
      font-size: 16px;
      font-family: 'Montserrat', sans-serif;
      transition: all 0.3s ease;
      background: #f8f9fa;
    }

    .field-wrap input:focus {
      outline: none;
      border-color: #00ff11ff;
      background: white;
      box-shadow: 0 0 0 4px rgba(111, 234, 102, 0.18);
    }

    .button {
      width: 100%;
      padding: 16px;
      background: linear-gradient(135deg, #00ff3a 0%, #005e30 100%);
      color: white;
      border: none;
      border-radius: 10px;
      font-size: 16px;
      font-weight: 600;
      font-family: 'Montserrat', sans-serif;
      cursor: pointer;
      transition: all 0.3s ease;
      margin-top: 10px;
    }

    .button:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
    }

    .button:active {
      transform: translateY(0);
    }

    .forgot {
      text-align: right;
      margin-top: 15px;
    }

    .forgot a {
      color: #667eea;
      text-decoration: none;
      font-size: 14px;
      transition: color 0.3s ease;
    }

    .forgot a:hover {
      color: #764ba2;
      text-decoration: underline;
    }

    @media (max-width: 768px) {
      .login-container {
        flex-direction: column;
        max-width: 450px;
      }

      .left-section {
        padding: 40px 20px;
        min-height: 300px;
      }

      .logo-container img {
        width: 120px;
        height: 120px;
      }

      .logo-container h2 {
        font-size: 24px;
      }

      .right-section {
        padding: 40px 30px;
      }

      .form-header h1 {
        font-size: 26px;
      }
    }
  </style>
</head>

<body>
  <div class="login-container">
    <div class="left-section">
      <div class="logo-container">
        <img src="andre4kp.png" alt="Logo">
        <h2>Andre's Design</h2>
        <p>Bienvenido de nuevo</p>
      </div>
    </div>

    <div class="right-section">
      <div class="form-header">
        <h1>Iniciar Sesión</h1>
        <p>Ingresa tus credenciales para continuar</p>
      </div>

      <form action="login.php" method="post">
        <div class="field-wrap">
          <label>
            Usuario<span class="req">*</span>
          </label>
          <input type="text" name="user" required autocomplete="off" placeholder="Ingresa tu usuario" />
        </div>

        <div class="field-wrap">
          <label>
            Contraseña<span class="req">*</span>
          </label>
          <input type="password" name="password" required autocomplete="off" placeholder="Ingresa tu contraseña" />
        </div>

        <!-- <p class="forgot"><a href="#">¿Olvidaste tu contraseña?</a></p> -->

        <button type="submit" class="button">Ingresar</button>
      </form>
    </div>
  </div>
</body>

</html>