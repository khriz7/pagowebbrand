<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Imprimir Resultado</title>
</head>
<body>
  <center><h1>Resultado del API</h1></center>
  <?php
  // Obtener el resultado del API desde el parámetro de la URL
  if (isset($_GET['respuesta'])) {
    $respuestaAPI = $_GET['respuesta'];
    echo "<p>$respuestaAPI</p>";
  } else {
    echo "<p>No se recibió el resultado del API.</p>";
  }
  ?>
  <script>
    // Imprimir automáticamente la página al cargar
    window.onload = function() {
      window.print();
    };
  </script>
</body>
</html>
