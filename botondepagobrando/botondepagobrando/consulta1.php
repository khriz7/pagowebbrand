<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Consulta</title>
</head>
<style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f0f0f0;
      margin: 0;
      padding: 0;
    }
    h1 {
      text-align: center;
    }
    form {
      max-width: 400px;
      margin: 0 auto;
      padding: 20px;
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
    }
    label {
      display: block;
      margin-bottom: 8px;
      font-weight: bold;
    }
    input[type="text"],
    input[type="password"] {
      width: 100%;
      padding: 8px;
      margin-bottom: 16px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }
    input[type="submit"] {
      background-color: #007bff;
      color: #fff;
      padding: 10px 20px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }
    input[type="submit"]:hover {
      background-color: #0056b3;
    }
  </style>
<body>
  <h1>Consulta de venta</h1>
<form action="respuestaconsulta.php" method="POST">
        <label for="user">Usuario:</label>
        <input type="text" name="user" value="integraciones.visanet@necomplus.com"required><br>
        <label for="password">Contraseña:</label>
        <input type="password" name="password" required value="d5e7nk$M"><br>
        <label for="merchantCode">Código de Comercio:</label>
        <input type="text" name="merchant"value="522591303" required><br>
        <label for="purchaseNumber">Número de Pedido:</label>
        <input type="text" name="purchaseNumber"  value="2342891" required><br>
        <input type="submit" value="enviar" name="enviar">
    </form>
</body>
</html>
